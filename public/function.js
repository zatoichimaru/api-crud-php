var apiUrl="/test/api/index";
function sendAndReloadTable(method,jsonContent){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var result=JSON.parse(this.responseText);
            alert(result.message);
            reloadTable();
        }
    };
    xhttp.open(method, apiUrl, true);
    xhttp.send(JSON.stringify(jsonContent));
}

function saveNew(){
    var nameInput=document.getElementById("name_New");
    var priceInput=document.getElementById("price_New");
    var name=nameInput.value;
    var price=priceInput.value;
    nameInput.value="";
    priceInput.value="";
    sendAndReloadTable("POST",{"name":name,"price":price})
}

function updateRow(id){
    var name=document.getElementById("name_"+id).value;
    var price=document.getElementById("price_"+id).value;
    sendAndReloadTable("PUT",{"id":id,"name":name,"price":price});
}

function deleteRow(id){
    sendAndReloadTable("DELETE",{"id":id});
}

function reloadTable(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var result=JSON.parse(this.responseText);
            var tbody=document.getElementById("product-content");
            for(var i=tbody.rows.length-1;i>=0;i--){
                tbody.deleteRow(i);
            }
            if(result.data.length>0){
                for (i = 0; i < result.data.length; i++) {
                    var resultRow = result.data[i];
                    var row = tbody.insertRow(i);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    cell1.innerHTML = "<input type=\"text\" readonly=\"readonly\" id=\"id_"+resultRow.id+"\" name=\"id_"+resultRow.id+"\" value=\""+resultRow.id+"\"/>";
                    cell2.innerHTML = "<input type=\"text\" id=\"name_"+resultRow.id+"\" name=\"name_"+resultRow.id+"\" value=\""+resultRow.name+"\"/>";
                    cell3.innerHTML = "<input type=\"number\" id=\"price_"+resultRow.id+"\" name=\"price_"+resultRow.id+"\" min=\"0\" step=\"0.01\" value=\""+resultRow.price+"\"/>";
                    cell4.innerHTML = "<button type=\"button\" onclick=\"updateRow("+resultRow.id+");\" class=\"btn btn-info product-update\">Editar</button><button  type=\"button\" onclick=\"deleteRow("+resultRow.id+");\" id=\"delete_"+resultRow.id+"\" class=\"btn btn-danger product-delete\">Excluir</button>";
                }
            }else{
                var row = tbody.insertRow(0);
                var cell1 = row.insertCell(0);
                cell1.colspan=4;
                cell1.innerHTML="Nehum produto cadastrado";
            }
        }
    };
    xhttp.open("GET", apiUrl, true);
    xhttp.send();
}

