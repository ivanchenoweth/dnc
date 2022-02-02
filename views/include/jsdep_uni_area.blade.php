<script>
function jsdep_uni_area() {
   //window.alert("|hey jude|");

    var actEle = document.activeElement;     
    var actEleID = actEle.id;

    var ID = document.getElementById("dependencia_ini");
    var TE = ID.options[ID.selectedIndex].text  ;       
    var VA = document.getElementById("dependenciaini");
    VA.value= TE;
  
    ///////////////////////////////////////////////////////////////
    // dio clic en dependencia inicial?
    //
    if (actEleID === "dependencia_ini") {
      var IDn = document.getElementById("dependencia_fin");
     
      // limpia el combo dependencia_fin
      for (var i = IDn.options.length; i >= 0; i--) {
         IDn.remove(i);
      }      
      //window.alert("|"+ID.options.length+"|"+VA.value+"|");
      var j = 0;
      // recorre los elementos de dependencia_ini
      for (var i = 0; i < ID.options.length ; i++) {
        //window.alert("|"+ID.options[i].text.substring(0,2)+ "|"+ ID.options[i].text +"|"+ID.options.length+"|"+VA.value+"|"); 
        // si dependencia_ini >= dependenciaini? inserta en dependencia_fin
        if (ID.options[i].text >= VA.value) {
            var option = document.createElement('option');
            option.value = ID.options[i].text;
            option.text = ID.options[i].text;
            IDn.appendChild(option);
            j = j + 1;
         }
      } 
      // selecciona el ultimo elemento en dependencia_fin
      IDn.selectedIndex = j - 1;
         
   }

   ID = document.getElementById("dependencia_ini");
   TE = ID.options[ID.selectedIndex].text  ;       
   VA = document.getElementById("dependenciaini");
   VA.value= TE;

   ID = document.getElementById("dependencia_fin");
   TE = ID.options[ID.selectedIndex].text  ;       
   VA = document.getElementById("dependenciafin");
   VA.value= TE;

  
   ID = document.getElementById("unidad_ini");
   TE = ID.options[ID.selectedIndex].text  ;       
   VA = document.getElementById("unidadini");
   VA.value= TE;

   ID = document.getElementById("unidad_fin");
   TE = ID.options[ID.selectedIndex].text  ;       
   VA = document.getElementById("unidadfin");
   VA.value= TE;

   var ID1 = document.getElementById("area_ini");   	
   var TE1 = ID1.options[ID1.selectedIndex].text  ;       
   var VA1 = document.getElementById("areaini");
   VA1.value= TE1;

   var ID2 = document.getElementById("area_fin");   	
   var TE2 = ID2.options[ID2.selectedIndex].text  ;       
   var VA2 = document.getElementById("areafin");
   VA2.value= TE2;
}
</script>