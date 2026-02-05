@extends('tenant.admin.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/admin/dataTable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ url('tenant/admin/dataTable/css/dataTables.bootstrap4.min.css') }}">
    <style>
        h4.card-title {
            background: linear-gradient(to right, #17263A, #2c3e50, #17263A);
            padding: 8px 15px;
            border-radius: 4px;
            color: white;
        }

        .user-info {
            line-height: 1.4;
        }

        .user-info .text-muted {
            font-size: 12px;
        }

        /* Admin Notes Modal Styling */
        #adminNotesModal .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        #adminNotesModal .modal-header .close {
            color: white;
            opacity: 0.8;
        }

        #adminNotesModal .modal-header .close:hover {
            opacity: 1;
        }

        #adminNotesModal textarea {
            border: 2px solid #e9ecef;
            transition: border-color 0.3s;
        }

        #adminNotesModal textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        #adminNotesModal .alert-info {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-color: #667eea;
        }

        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        #loadingOverlay .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        #loadingOverlay .loading-text {
            color: white;
            margin-top: 1rem;
            font-size: 1.1rem;
        }
    </style>
@endsection

@section('page_title')
    Withdrawal Requests
@endsection

@section('page_heading')
    Withdrawal Management
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Withdrawal Requests</h4>
                    <div class="table-responsive mt-3">
                        <table id="withdrawRequestTable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User</th>
                                    <th>User ID</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Payment Details</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Notes Modal -->
    <div class="modal fade" id="adminNotesModal" tabindex="-1" role="dialog" aria-labelledby="adminNotesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminNotesModalLabel">
                        <i class="fas fa-clipboard-check"></i> <span id="modalActionTitle">Approve</span> Withdrawal Request
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="adminNotesForm">
                        <input type="hidden" id="withdrawalId" name="id">
                        <input type="hidden" id="withdrawalStatus" name="status">

                        <div class="form-group">
                            <label for="adminNotes">Admin Notes <span id="notesRequired" class="text-danger"
                                    style="display:none;">*</span></label>
                            <textarea class="form-control" id="adminNotes" name="admin_notes" rows="4"
                                placeholder="Enter your notes here (e.g., approval reason, rejection reason, payment details, etc.)"></textarea>
                            <small class="form-text text-muted" id="notesHelpText">
                                Optional: Add any notes or comments for this action
                            </small>
                        </div>

                        <div class="alert alert-info" id="actionInfoAlert">
                            <i class="fas fa-info-circle"></i> <span id="actionInfoText"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn" id="confirmActionBtn">
                        <i class="fas fa-check"></i> <span id="confirmBtnText">Confirm</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="{{ asset('tenant/admin/dataTable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('tenant/admin/dataTable/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            console.log('Initializing Withdrawal Request DataTable...');

            var table = $('#withdrawRequestTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mlm.user.withdraw.request') }}",
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [{
                        data: 'user',
                        name: 'u.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user_id_badge',
                        name: 'wr.user_id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'amount_formatted',
                        name: 'wr.amount',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'payment_method_badge',
                        name: 'wr.payment_method',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'payment_info',
                        name: 'wr.payment_details',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status_badge',
                        name: 'wr.status',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'request_date',
                        name: 'wr.created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [6, 'desc']
                ], // Sort by request date
                pageLength: 25,
                language: {
                    emptyTable: "No withdrawal requests found",
                    zeroRecords: "No matching requests found"
                }
            });

            // Approve button handler
            $(document).on('click', '.approve-btn', function() {
                var requestId = $(this).data('id');
                var adminNotes = $(this).data('adminNotes') || $(this).attr('data-admin-notes') || '';
                openAdminNotesModal(requestId, 'approved', adminNotes);
            });

            // Reject button handler
            $(document).on('click', '.reject-btn', function() {
                var requestId = $(this).data('id');
                var adminNotes = $(this).data('adminNotes') || $(this).attr('data-admin-notes') || '';
                openAdminNotesModal(requestId, 'rejected', adminNotes);
            });

            // View-only note handler for processed requests
            $(document).on('click', '.view-note-btn', function() {
                var adminNotes = $(this).data('adminNotes') || $(this).attr('data-admin-notes') || '';
                openAdminNotesModal(null, 'view', adminNotes);
            });

            // Open modal with appropriate configuration
            function openAdminNotesModal(requestId, status, adminNotes) {
                // Set form values
                $('#withdrawalId').val(requestId || '');
                $('#withdrawalStatus').val(status === 'view' ? '' : status);
                $('#adminNotes').val(adminNotes || '');

                // Default state: editable, show confirm
                $('#adminNotes').prop('readonly', false);
                $('#confirmActionBtn').show();
                $('#notesRequired').toggle(status === 'rejected');

                // Configure modal based on status
                if (status === 'approved') {
                    $('#modalActionTitle').text('Approve');
                    $('#confirmActionBtn').removeClass('btn-danger').addClass('btn-success');
                    $('#confirmBtnText').text('Approve Request');
                    $('#actionInfoText').text(
                        'You are about to approve this withdrawal request. The payment will be processed.');
                    $('#notesHelpText').text('Optional: Add approval notes or payment reference details');
                } else if (status === 'rejected') {
                    $('#modalActionTitle').text('Reject');
                    $('#confirmActionBtn').removeClass('btn-success').addClass('btn-danger');
                    $('#confirmBtnText').text('Reject Request');
                    $('#actionInfoText').text(
                        'You are about to reject this withdrawal request. The amount will be returned to user wallet.'
                    );
                    $('#notesHelpText').text('Recommended: Provide a reason for rejection');
                } else if (status === 'view') {
                    // View-only mode
                    $('#modalActionTitle').text('View');
                    $('#actionInfoText').text('Viewing admin note for this processed request.');
                    $('#notesHelpText').text('');
                    $('#adminNotes').prop('readonly', true);
                    $('#confirmActionBtn').hide();
                    $('#notesRequired').hide();
                }

                // Show modal
                $('#adminNotesModal').modal('show');
            }

            // Handle modal form submission
            $('#confirmActionBtn').on('click', function() {
                var requestId = $('#withdrawalId').val();
                var status = $('#withdrawalStatus').val();
                var adminNotes = $('#adminNotes').val().trim();

                // Optional validation for reject - recommend notes but don't enforce
                if (status === 'rejected' && !adminNotes) {
                    if (!confirm('No rejection reason provided. Continue anyway?')) {
                        return;
                    }
                }

                // Close modal
                $('#adminNotesModal').modal('hide');

                // Submit the request
                updateWithdrawalStatus(requestId, status, adminNotes);
            });

            // Generic function to update withdrawal status
            function updateWithdrawalStatus(id, status, adminNotes = null) {
                var requestData = {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                };

                if (adminNotes) {
                    requestData.admin_notes = adminNotes;
                }

                // Show loading overlay or disable table interactions
                $.ajax({
                    url: "{{ route('mlm.withdraw.update.status') }}",
                    type: 'POST',
                    data: requestData,
                    beforeSend: function() {
                        // Add loading indicator with status message
                        var statusText = status === 'approved' ? 'Approving' : 'Rejecting';
                        $('body').append(
                            '<div id="loadingOverlay">' +
                            '<div class="spinner-border text-light" role="status">' +
                            '<span class="sr-only">Processing...</span>' +
                            '</div>' +
                            '<div class="loading-text">' + statusText +
                            ' withdrawal request...</div>' +
                            '</div>'
                        );
                    },
                    success: function(response) {
                        $('#loadingOverlay').remove();

                        if (response.success) {
                            // Refresh DataTable
                            table.ajax.reload(null, false);

                            // Show success notification (Toastr called in controller)
                            console.log('Success:', response.message);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#loadingOverlay').remove();

                        var errorMsg = 'Failed to update status';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert('Error: ' + errorMsg);
                        console.error('AJAX error:', xhr);
                    }
                });
            }

            console.log('DataTable initialized:', table);
        });
    </script>
@endsection
