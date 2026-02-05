@extends('tenant.frontend.layouts.app')

@section('header_css')
    <link rel="stylesheet" href="{{ url('tenant/frontend') }}/css/user-pannel.css" />
    <style>
        /* Responsive for mobile */
        @media (max-width: 768px) {
            .dashboard-head-widget {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }

            .dashboard-head-widget-btn {
                width: 100%;
            }

            .dashboard-head-widget-btn a {
                width: 100%;
                justify-content: center;
            }

            /* Convert table to card layout on mobile */
            .support-ticket-table-data tbody tr {
                display: block;
                margin-bottom: 16px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px;
                background: white;
            }

            .support-ticket-table-data tbody td {
                display: block;
                padding: 8px 0;
                border-bottom: 1px solid #f1f5f9;
                text-align: left !important;
            }

            .support-ticket-table-data tbody td:last-child {
                border-bottom: none;
            }

            .support-ticket-number,
            .support-ticket-date,
            .support-ticket-text {
                display: block;
                margin-bottom: 4px;
            }

            .support-ticket-status-btn {
                margin: 8px 0;
            }

            .open-ticket-btn {
                width: 100%;
                text-align: center;
                display: block;
                margin-top: 8px;
            }
        }
    </style>
@endsection

@push('site-seo')

    <title>
        @if ($generalInfo && $generalInfo->meta_title)
            {{ $generalInfo->meta_title }}
        @else
            {{ $generalInfo->company_name }}
        @endif
    </title>
    @if ($generalInfo && $generalInfo->fav_icon)
        <link rel="icon" href="{{  $generalInfo->fav_icon }}" type="image/x-icon" />
    @endif
@endpush

@push('user_dashboard_menu')
    @include('tenant.frontend.pages.customer_panel.layouts.partials.mobile_menu_offcanvus')
@endpush

@section('content')
    <section class="getcom-user-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="getcom-user-body-bg">
                        <img alt="" src="{{ url('tenant/frontend') }}/assets/images/user-hero-bg.png" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-12">
                    @include('tenant.frontend.pages.customer_panel.layouts.partials.menu')
                </div>
                <div class="col-lg-12 col-xl-9 col-12">
                    <div class="dashboard-support-ticket mgTop24">
                        <div class="dashboard-head-widget style-2" style="margin-bottom: 16px">
                            <h5 class="dashboard-head-widget-title">{{ __('customer.support_tickets') }}</h5>
                            <div class="dashboard-head-widget-btn">
                                <a class="theme-btn secondary-btn icon-right" href="{{ url('create/ticket') }}"><i
                                        class="fi-rr-plus"></i>{{ __('customer.create_ticket') }}</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="support-ticket-table-data table">
                                <tbody>

                                    @if (count($supportTickets) > 0)
                                        @foreach ($supportTickets as $supportTicket)
                                            <tr>
                                                <td>
                                                    <span class="support-ticket-number">
                                                        <img alt=""
                                                            src="{{ url('tenant/frontend') }}/assets/images/icons/messages.svg">
                                                        {{ $supportTicket->ticket_no }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="support-ticket-date">{{ date('jS M, Y h:i A', strtotime($supportTicket->created_at)) }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="support-ticket-text">{{ substr($supportTicket->subject, 0, 60) }}...</span>
                                                </td>
                                                <td>
                                                    @if ($supportTicket->status == 0)
                                                        <span class="support-ticket-status-btn"
                                                            style="background: #0074e4">{{ __('customer.pending') }}</span>
                                                    @elseif($supportTicket->status == 1)
                                                        <span class="support-ticket-status-btn cancelled">{{ __('customer.in_progress') }}</span>
                                                    @elseif($supportTicket->status == 2)
                                                        <span class="support-ticket-status-btn open">{{ __('customer.solved') }}</span>
                                                    @elseif($supportTicket->status == 3)
                                                        <span class="support-ticket-status-btn closed">{{ __('customer.rejected') }}</span>
                                                    @else
                                                        <span class="support-ticket-status-btn hold">{{ __('customer.on_hold') }}</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <a class="open-ticket-btn"
                                                        href="{{ url('support/ticket/message') }}/{{ $supportTicket->slug }}">{{ __('customer.open_ticket') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                {{ __('customer.no_tickets') }}
                                            </td>
                                        </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
