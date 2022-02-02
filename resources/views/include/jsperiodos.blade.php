<script>
function jsperiodos() 
{
   var actEle = document.activeElement;     
   var actEleID = actEle.id;

   //window.alert("|hey|");
   var ID = document.getElementById("periodo_ini");   	
   var TE = ID.options[ID.selectedIndex].text  ;       
   var VA = document.getElementById("periodoini");
   VA.value= TE.substr(0,3);

   var ID2 = document.getElementById("periodo_fin");   	
   var TE2 = ID2.options[ID2.selectedIndex].text  ;       
   var VA2 = document.getElementById("periodofin");
   VA2.value= TE2.substr(0,3);
   

   ///////////////////////////////////////////////////////////////
   //
   // dio clic en periodo inicial?
   //
   //window.alert("|"+actEleID+"|");
   if (actEleID === "periodo_ini") {
      var IDn = document.getElementById("periodo_fin");
     
      // limpia el combo periodo_fin
      for (var i = IDn.options.length; i >= 0; i--) {
         IDn.remove(i);
      }      
      //window.alert("|"+ID.options.length+"|"+VA.value+"|");
      var j = 0;
      // recorre los elementos de periodos_ini
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
      // selecciona el ultimo elemento en perdiodo_fin
      IDn.selectedIndex = j - 1;         
   }
   
}
</script>