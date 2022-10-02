<tr>
    <td class="t_tittle" id="t_tittle"><input type="hidden" name="pid[]" value="3629"><input type="hidden"
            id="product_storage" name="product_storage" class="product_name"
            value="Rupastar Tablet,   10 mg,   ">Rupastar Tablet, 10 mg, <br> <span class="text-success"></span></td>
    <td><input type="number" step="any" value="1" class="form-control border-dark w-100px quantity" id="quantity"
            name="quantity[]" max="1"> <span class="text-danger">Max: 1 piece</span></td>
    <td><input type="number" step="any" value="120" class="form-control border-dark w-100px pricesum" id="price"
            name="price[]"></td>
    <td><span>Percent: </span><input type="number" step="any" value="0"
            class="form-control-sm border-dark w-100px discount_percent" onchange="change_indv_p_discount_percent(3629)"
            onkeyup="change_indv_p_discount_percent(3629)" id="disCP_3629" name="disCP[]"><br><span>Flat Rate:
        </span><input type="number" step="any" value="0" class="form-control-sm flat_discount border-dark w-100px"
            onkeyup="change_indv_p_flat_discount(3629)" onchange="change_indv_p_flat_discount(3629)" id="disC_flat_3629"
            name="disC_flat[]"></td>
    <td><input type="number" readonly="" step="any" value="0"
            class="form-control-sm border-dark w-70px individual_product_vat" id="individual_product_vat"
            name="individual_product_vat[]"></td>
    <td><input type="number" step="any" value="" class="form-control-sm border-dark w-70px total" readonly="" id="total"
            name="total[]"></td>
    <td>
        <div class="card-toolbar text-center"><span><i onclick="deleteRow(this)"
                    class="fas fa-trash-alt text-danger remove btnSelect"></i></span></div>
    </td>
</tr>
