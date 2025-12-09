@extends('tenant.admin.layouts.app')

@section('header_css')
    <link href="{{ asset('tenant/admin/dataTable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('tenant/admin/dataTable/css/dataTables.bootstrap4.min.css') }} " rel="stylesheet">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px;
            border-radius: 4px;
        }

        table.dataTable tbody td:nth-child(1) {
            text-align: center !important;
            font-weight: 600;
        }

        table.dataTable tbody td:nth-child(2) {
            text-align: center !important;
        }

        table.dataTable tbody td:nth-child(3) {
            text-align: center !important;
        }

        table.dataTable tbody td:nth-child(4) {
            text-align: center !important;
        }

        table.dataTable tbody td:nth-child(5) {
            text-align: center !important;
        }

        table.dataTable tbody td:nth-child(6) {
            text-align: center !important;
            min-width: 100px !important;
        }

        table.dataTable tbody td:nth-child(7) {
            text-align: center !important;
            min-width: 80px !important;
        }

        table.dataTable tbody td:nth-child(8) {
            text-align: center !important;
            min-width: 80px !important;
        }

        table.dataTable tbody td:nth-child(9) {
            text-align: center !important;
            min-width: 80px !important;
        }

        table.dataTable tbody td:nth-child(10) {
            text-align: center !important;
            min-width: 100px !important;
        }

        tfoot {
            display: table-header-group !important;
        }

        tfoot th {
            text-align: center;
        }
    </style>
@endsection

@section('page_title')
    System
@endsection
@section('page_heading')
    View All Email Configurations
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">SMTP Email Configurations</h4>
                    <div class="table-responsive">
                        <form method="POST" action="{{ url('save/new/email/configure') }}" class="form-horizontal">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <input type="hidden" name="email_config_slug" id="email_config_slug"
                                value="{{ $data->slug ?? '' }}">

                            <div class="form-group">
                                <label>Host Server<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="host" id="host"
                                    value="{{ old('host', $data->host ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Server PORT<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="port" id="port"
                                    value="{{ old('port', $data->port ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Email/Username<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $data->email ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password"
                                    value="{{ old('password', optional($data)->getDecryptedPassword()) }}"
                                    {{ empty($data) ? 'required' : '' }}>
                            </div>

                            <div class="form-group">
                                <label>Mail From Name</label>
                                <input type="text" class="form-control" name="mail_from_name" id="mail_from_name"
                                    value="{{ old('mail_from_name', $data->mail_from_name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>Mail From Email</label>
                                <input type="email" class="form-control" name="mail_from_email" id="mail_from_email"
                                    value="{{ old('mail_from_email', $data->mail_from_email ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>Encryption<span class="text-danger">*</span></label>
                                <select class="form-control" id="encryption" name="encryption" required>
                                    <option value="0"
                                        {{ old('encryption', $data->encryption ?? 0) == 0 ? 'selected' : '' }}>No
                                        Encryption</option>
                                    <option value="1"
                                        {{ old('encryption', $data->encryption ?? 0) == 1 ? 'selected' : '' }}>TLS
                                        Encryption</option>
                                    <option value="2"
                                        {{ old('encryption', $data->encryption ?? 0) == 2 ? 'selected' : '' }}>SSL
                                        Encryption</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" {{ old('status', $data->status ?? 1) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('status', $data->status ?? 1) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ url()->current() }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
