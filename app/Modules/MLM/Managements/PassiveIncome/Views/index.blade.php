@extends('tenant.admin.layouts.app')

@section('header_css')
    <style>
        .gradient-title {
            background: linear-gradient(90deg, #8e2de2, #4a00e0);
            color: #fff;
            padding: 12px 15px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .edit-mode-input {
            border: 2px dashed #007bff !important;
            background-color: #f8f9fa !important;
        }

        .commission-row {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: #f8f9fa;
        }
    </style>
@endsection

@section('page_title')
    Passive Income
@endsection

@section('page_heading')
    Passive Income Management
@endsection

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">
                <div class="gradient-title mb-4">
                    <h5 class="mb-0 text-white">{{ $content->header_title ?? 'Passive Income' }}</h5>
                    <div>
                        @if ($edit)
                            <a href="{{ route('mlm.passive.income') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-eye"></i> View Mode
                            </a>
                        @else
                            <a href="{{ route('mlm.passive.income', ['edit' => 1]) }}" class="btn btn-sm btn-light">
                                <i class="fas fa-edit"></i> Edit Mode
                            </a>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('mlm.passive.income.update') }}">
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

                    <div class="card mb-3">
                        <div class="card-body text-center">
                            @if ($edit)
                                <input type="text" name="header_title" class="form-control edit-mode-input mb-2"
                                    value="{{ old('header_title', $content->header_title ?? '') }}"
                                    placeholder="Header Title">
                                <textarea name="header_subtitle" class="form-control edit-mode-input" rows="2" placeholder="Subtitle">{{ old('header_subtitle', $content->header_subtitle ?? '') }}</textarea>
                            @else
                                <p>{{ $content->header_subtitle ?? '' }}</p>
                            @endif

                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($edit)
                                <input type="text" name="what_is_title" class="form-control edit-mode-input mb-2"
                                    value="{{ old('what_is_title', $content->what_is_title ?? '') }}">
                                <textarea name="what_is_text" class="form-control edit-mode-input" rows="3">{{ old('what_is_text', $content->what_is_text ?? '') }}</textarea>
                            @else
                                <p class="text-brand font-weight-bold">{{ $content->what_is_title ?? '' }}</p>
                                <p>{{ $content->what_is_text ?? '' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($edit)
                                <input type="text" name="how_title" class="form-control edit-mode-input mb-2"
                                    value="{{ old('how_title', $content->how_title ?? '') }}">
                                <textarea name="how_text" class="form-control edit-mode-input" rows="3">{{ old('how_text', $content->how_text ?? '') }}</textarea>
                            @else
                                <p class="text-brand font-weight-bold">{{ $content->how_title ?? '' }}</p>
                                <p>{{ $content->how_text ?? '' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if ($edit)
                                    <input type="text" name="commission_title" class="form-control edit-mode-input"
                                        style="width: auto;"
                                        value="{{ old('commission_title', $content->commission_title ?? 'সেলস কমিশন রেট') }}">
                                    <button type="button" class="btn btn-sm btn-success" id="addRate">
                                        <i class="fas fa-plus"></i> Add Rate
                                    </button>
                                @else
                                    <h6>{{ $content->commission_title ?? 'সেলস কমিশন রেট' }}</h6>
                                @endif
                            </div>

                            @if ($edit)
                                <div id="ratesContainer">
                                    @foreach ($commissionRates as $i => $rate)
                                        <div class="commission-row">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Min (৳)</label>
                                                    <input type="number"
                                                        name="commission_rates[{{ $i }}][min_price]"
                                                        class="form-control form-control-sm" value="{{ $rate->min_price }}"
                                                        required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Max (৳)</label>
                                                    <input type="number"
                                                        name="commission_rates[{{ $i }}][max_price]"
                                                        class="form-control form-control-sm" value="{{ $rate->max_price }}"
                                                        required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>L1 (৳)</label>
                                                    <input type="number"
                                                        name="commission_rates[{{ $i }}][level_1_commission]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $rate->level_1_commission }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>L2 (৳)</label>
                                                    <input type="number"
                                                        name="commission_rates[{{ $i }}][level_2_commission]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $rate->level_2_commission }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>L3 (৳)</label>
                                                    <input type="number"
                                                        name="commission_rates[{{ $i }}][level_3_commission]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $rate->level_3_commission }}" required>
                                                </div>
                                                <div class="col-md-1">
                                                    <label>L4 (৳)</label>
                                                    <input type="number"
                                                        name="commission_rates[{{ $i }}][level_4_commission]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $rate->level_4_commission }}" required>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-sm btn-danger remove-rate"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>প্রাইস রেঞ্জ</th>
                                            <th>১ম</th>
                                            <th>২য়</th>
                                            <th>৩য়</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($commissionRates as $rate)
                                            <tr>
                                                <td>৳{{ number_format($rate->min_price) }} -
                                                    ৳{{ number_format($rate->max_price) }}</td>
                                                <td>৳{{ number_format($rate->level_1_commission) }}</td>
                                                <td>৳{{ number_format($rate->level_2_commission) }}</td>
                                                <td>৳{{ number_format($rate->level_3_commission) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No rates</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>

                    @if ($edit)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6>Statistics</h6>
                                <div class="row">
                                    <div class="col-md-3"><label><input type="checkbox" name="is_verified_seller"
                                                value="1"
                                                {{ isset($stat) && $stat->is_verified_seller ? 'checked' : '' }}>
                                            Verified</label></div>
                                    <div class="col-md-2"><label>Level-1</label><input type="number"
                                            name="level_1_count" class="form-control"
                                            value="{{ old('level_1_count', $stat->level_1_count ?? 0) }}" required></div>
                                    <div class="col-md-2"><label>Level-2</label><input type="number"
                                            name="level_2_count" class="form-control"
                                            value="{{ old('level_2_count', $stat->level_2_count ?? 0) }}" required></div>
                                    <div class="col-md-2"><label>Level-3</label><input type="number"
                                            name="level_3_count" class="form-control"
                                            value="{{ old('level_3_count', $stat->level_3_count ?? 0) }}" required></div>
                                    <div class="col-md-3"><label>Level-4</label><input type="number"
                                            name="level_4_count" class="form-control"
                                            value="{{ old('level_4_count', $stat->level_4_count ?? 0) }}" required></div>
                                    <div class="col-md-4 mt-2"><label>Delivered</label><input type="number"
                                            name="delivered_orders" class="form-control"
                                            value="{{ old('delivered_orders', $stat->delivered_orders ?? 0) }}" required>
                                    </div>
                                    <div class="col-md-4 mt-2"><label>Daily Commission</label><input type="number"
                                            step="0.01" name="estimated_daily_commission" class="form-control"
                                            value="{{ old('estimated_daily_commission', isset($stat) ? number_format($stat->estimated_daily_commission, 2, '.', '') : '0.00') }}"
                                            required></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-md-3"><strong>Level-1</strong>
                                        <div class="h4">{{ $stat->level_1_count ?? 0 }}</div>
                                    </div>
                                    <div class="col-md-3"><strong>Level-2</strong>
                                        <div class="h4">{{ $stat->level_2_count ?? 0 }}</div>
                                    </div>
                                    <div class="col-md-3"><strong>Level-3</strong>
                                        <div class="h4">{{ $stat->level_3_count ?? 0 }}</div>
                                    </div>
                                    <div class="col-md-3"><strong>Orders</strong>
                                        <div class="h4">{{ $stat->delivered_orders ?? 0 }}</div>
                                    </div>
                                </div>
                                <p class="mt-3">Daily Commission:
                                    <strong>৳{{ isset($stat) ? number_format($stat->estimated_daily_commission, 2) : '0.00' }}</strong>
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($edit)
                                <textarea name="conclusion_text" class="form-control edit-mode-input" rows="4" placeholder="Conclusion">{{ old('conclusion_text', $content->conclusion_text ?? '') }}</textarea>
                            @else
                                <p>{{ $content->conclusion_text ?? '' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($edit)
                                <input type="text" name="terms_title" class="form-control edit-mode-input mb-2"
                                    value="{{ old('terms_title', $content->terms_title ?? '') }}">
                                <textarea name="terms_html" class="form-control edit-mode-input" rows="5">{{ old('terms_html', $content->terms_html ?? '') }}</textarea>
                            @else
                                <p class="text-brand font-weight-bold">{{ $content->terms_title ?? '' }}</p>
                                {!! $content->terms_html ?? '' !!}
                            @endif
                        </div>
                    </div>

                    @if ($edit)
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i>
                                Save</button>
                            <a href="{{ route('mlm.passive.income') }}" class="btn btn-secondary btn-lg">Cancel</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    @if ($edit)
        <script>
            let idx = {{ count($commissionRates) }};
            document.getElementById('addRate').addEventListener('click', function() {
                const container = document.getElementById('ratesContainer');
                const div = document.createElement('div');
                div.className = 'commission-row';
                div.innerHTML = `<div class="row">
        <div class="col-md-2"><label>Min (৳)</label><input type="number" name="commission_rates[${idx}][min_price]" class="form-control form-control-sm" value="0" required></div>
        <div class="col-md-2"><label>Max (৳)</label><input type="number" name="commission_rates[${idx}][max_price]" class="form-control form-control-sm" value="0" required></div>
        <div class="col-md-2"><label>L1 (৳)</label><input type="number" name="commission_rates[${idx}][level_1_commission]" class="form-control form-control-sm" value="0" required></div>
        <div class="col-md-2"><label>L2 (৳)</label><input type="number" name="commission_rates[${idx}][level_2_commission]" class="form-control form-control-sm" value="0" required></div>
        <div class="col-md-2"><label>L3 (৳)</label><input type="number" name="commission_rates[${idx}][level_3_commission]" class="form-control form-control-sm" value="0" required></div>
        <div class="col-md-1"><label>L4 (৳)</label><input type="number" name="commission_rates[${idx}][level_4_commission]" class="form-control form-control-sm" value="0" required></div>
        <div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-danger remove-rate"><i class="fas fa-trash"></i></button></div>
    </div>`;
                container.appendChild(div);
                idx++;
            });
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-rate')) {
                    if (confirm('Remove this rate?')) e.target.closest('.commission-row').remove();
                }
            });
        </script>
    @endif
@endsection
