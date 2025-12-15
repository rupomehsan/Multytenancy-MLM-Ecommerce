<tr>
    <td class="text-center">
        <input type="file" class="form-control" style="min-width: 100px;" name="product_variant_image[]">
    </td>

    @if (DB::table('config_setups')->where('code', 'color')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_color_id[]" data-toggle="select2" class="form-control">
                {!! $colors ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'measurement_unit')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_unit_id[]" data-toggle="select2" class="form-control">
                {!! $units ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'product_size')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_size_id[]" data-toggle="select2" class="form-control">
                {!! $product_sizes ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'region')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_region_id[]" data-toggle="select2" class="form-control">
                {!! $regions ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'sim')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_sim_id[]" data-toggle="select2" class="form-control">
                {!! $sim ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'storage')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_storage_type_id[]" data-toggle="select2" class="form-control">
                {!! $storage_types ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'product_warranty')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_warrenty[]" data-toggle="select2" class="form-control">
                {!! $product_warrenties ?? '' !!}
            </select>
        </td>
    @endif

    @if (DB::table('config_setups')->where('code', 'device_condition')->where('status', 1)->first())
        <td class="text-center">
            <select name="product_variant_device_condition_id[]" data-toggle="select2" class="form-control">
                {!! $device_conditions ?? '' !!}
            </select>
        </td>
    @endif

    <td class="text-center">
        <input type="number" class="form-control" name="product_variant_stock[]" style="min-width: 100px;"
            value="0" style="height: 34px;" placeholder="0">
    </td>
    <td class="text-center">
        <input type="number" class="form-control" name="product_variant_price[]" style="min-width: 100px;"
            value="0" style="height: 34px;" placeholder="0">
    </td>
    <td class="text-center">
        <input type="number" class="form-control" name="product_variant_discounted_price[]" style="min-width: 100px;"
            value="0" style="height: 34px;" placeholder="0">
    </td>
    <td class="text-center">
        <a href="javascript:void(0)" onclick="removeRow(this)"
            class="btn btn-danger rounded btn-sm d-inline text-white"><i class="feather-trash-2"
                style="font-size: 14px; line-height: 2"></i></a>
    </td>
</tr>
