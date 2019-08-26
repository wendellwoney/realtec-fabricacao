function addFormula(idInsumo) {
    if ($("#quantidade"+idInsumo).val() == "") {
        alert("Informe uma quantidade para o insumo " + $("#nome"+idInsumo).text());
        return;
    }
    if ($("#comp"+idInsumo).val() == "") {
        alert("O insumo " + $("#nome"+idInsumo).text() + " já está adicionado a composição!");
        return;
    }

    var tr = "<tr class='composicao' id='comp"+ idInsumo +"'>";
    tr += "<td>";
    tr += "<input type='hidden' name='insumo[]' value='" + idInsumo + "'>";
    tr += "<input type='hidden' name='quantidade[" + idInsumo + "]' value='" + $("#quantidade"+idInsumo).val() + "'>";
    tr += $("#codigo"+idInsumo).text();
    tr += "</td>";
    tr += "<td>";
    tr += $("#nome"+idInsumo).text();
    tr += "</td>";
    tr += "<td class=\"text-center\">";
    tr += $("#quantidade"+idInsumo).val();
    tr += "</td>";
    tr += "<td class=\"text-center\">";
    tr += $("#unidade"+idInsumo).text();
    tr += "</td>";
    tr += "<td class=\"text-center\">";
    tr += '<button type="submit" class="btn btn-danger btn-sm" onclick="removerLinha('+ idInsumo +')"><span class="fa fa-window-close"></span> Remover</button>';
    tr += "</td>";
    tr += "</tr>";

    $("#default").attr('hidden',true);
    $("#formula").append(tr);
}

function removerLinha(idInsumo) {
    $("#comp" + idInsumo).remove();

    if($(".composicao").length == 0) {
        $("#default").attr('hidden',false);
    }
}