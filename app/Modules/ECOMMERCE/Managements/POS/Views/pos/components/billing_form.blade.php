<label style="margin-left: 20px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
    <input type="checkbox" id="flexCheckChecked" name="same_as_shipping" onchange="sameShippingBilling()" value="1"
        {{ old('same_as_shipping') == '1' ? 'checked' : '' }}
        style="display:inline-block !important; width:18px !important; height:18px !important; margin:0 !important; vertical-align:middle !important; opacity:1 !important; visibility:visible !important; position:relative !important; left:0 !important; -webkit-appearance:checkbox !important; appearance:checkbox !important; background:#fff !important; border:1px solid #ccd0d5 !important;" />
    <span style="vertical-align:middle;">Same as Shipping Address</span>
</label>
<div class="table-responsive">
    <table class="table mb-0">
        <tbody>
            <tr>
                <th style="width: 30%; line-height: 36px;">Billing Name</th>
                <td>
                    <input type="text" name="billing_name" id="billing_name"
                        class="form-control {{ $errors->has('billing_name') ? 'is-invalid' : '' }}"
                        placeholder="Full Name" value="{{ old('billing_name') }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('billing_name') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Billing Phone</th>
                <td>
                    <input type="text" name="billing_phone" id="billing_phone"
                        class="form-control {{ $errors->has('billing_phone') ? 'is-invalid' : '' }}"
                        placeholder="Phone No" value="{{ old('billing_phone') }}">
                    <div class="invalid-feedback"><strong>{{ $errors->first('billing_phone') }}</strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Billing Address</th>
                <td>
                    <input type="text" name="billing_address" id="billing_address" class="form-control"
                        placeholder="Street No/House No/Area">
                    <div class="invalid-feedback"><strong></strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Billing City</th>
                <td>
                    <select class="form-control" name="billing_district_id" id="billing_district_id"
                        data-toggle="select2">
                        <option value="">Select One</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"><strong></strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Sub-District/State</th>
                <td>
                    <select name="billing_thana_id" data-toggle="select2" id="billing_thana_id">
                        <option value="">Select One</option>
                    </select>
                    <div class="invalid-feedback"><strong></strong></div>
                </td>
            </tr>
            <tr>
                <th style="width: 30%; line-height: 36px;">Post Code</th>
                <td>
                    <input type="text" name="billing_postal_code" id="billing_postal_code" class="form-control"
                        placeholder="Post Code">
                    <div class="invalid-feedback"><strong></strong></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
