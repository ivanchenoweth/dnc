<label for="dependencia_ini">Dependencia Inicial:</label>
<select 
  oninput="jsdep_uni_area()"
  class="d-inline" name="dependencia_ini" id="dependencia_ini">
       @foreach($dependencia as $dep)
       <option value="{{ $dependencia_ini }}" 
       <?php                   
           if( $dep->dep_o_ent == $dependencia_ini) 
               echo 'selected="selected"'                
       ?>                     
       > 
       {{ $dep->dep_o_ent }}
       </option>
       @endforeach            
</select> 
<br>
<label for="dependencia_fin">Dependencia Final:</label>
<select 
  oninput="jsdep_uni_area()"
  class="d-inline" name="dependencia_fin" id="dependencia_fin">
       @foreach($dependencia as $dep)
       <option value="{{ $dependencia_fin }}" 
       <?php                   
           if( $dep->dep_o_ent == $dependencia_fin) 
               echo 'selected="selected"'                
       ?>                     
       > 
       {{ $dep->dep_o_ent  }}
       </option>
       @endforeach            
</select>
<br>
<label for="unidad_ini">Unidad Admva.Inicial:</label>
<select 
  oninput="jsdep_uni_area()"
  class="d-inline" name="unidad_ini" id="unidad_ini">
       @foreach($unidad as $uni)
       <option value="{{ $unidad_ini }}" 
       <?php                   
           if( $uni->unidad_admva == $unidad_ini) 
               echo 'selected="selected"'                
       ?>                     
       > 
       {{ $uni->unidad_admva }}
       </option>
       @endforeach            
</select> 
<br>
<label for="unidad_fin">Unidad Admva.Final:</label>
<select 
  oninput="jsdep_uni_area()"
  class="d-inline" name="unidad_fin" id="unidad_fin">
       @foreach($unidad as $uni)
       <option value="{{ $unidad_fin }}" 
       <?php                   
           if( $uni->unidad_admva == $unidad_fin) 
               echo 'selected="selected"'                
       ?>                     
       > 
       {{ $uni->unidad_admva }}
       </option>
       @endforeach
</select>
<br>
<label for="area_ini">Area Inicial:</label>
<select 
  oninput="jsdep_uni_area()"
  class="d-inline" name="area_ini" id="area_ini">
       @foreach($area as $are)
       <option value="{{ $area_ini }}" 
       <?php                   
           if( $are->area == $area_ini) 
               echo 'selected="selected"'                
       ?>                     
       > 
       {{ $are->area }}
       </option>
       @endforeach            
</select> 
<br>
<label for="area_fin">Area Final:</label>
<select 
  oninput="jsdep_uni_area()"
  class="d-inline" name="area_fin" id="area_fin">
       @foreach($area as $are)
       <option value="{{ $area_fin }}" 
       <?php                   
           if( $are->area == $area_fin) 
               echo 'selected="selected"'                
       ?>                     
       > 
       {{ $are->area }}
       </option>
       @endforeach
</select>
<p hidden>

<input type="hidden" id="dependenciaini" name= "dependenciaini" value="{{$dependencia_ini}}">
<input type="hidden" id="dependenciafin" name= "dependenciafin" value="{{$dependencia_fin}}">

<input type="hidden" id="unidadini" name= "unidadini" value="{{$unidad_ini}}">
<input type="hidden" id="unidadfin" name= "unidadfin" value="{{$unidad_fin}}">

<input type="hidden" id="areaini" name= "areaini" value="{{$area_ini}}">
<input type="hidden" id="areafin" name= "areafin" value="{{$area_fin}}">


<select name="dependencias" id="dependencias" disabled>
       @foreach($dependencia as $dep)
       <option value="{{ $dependencia_ini }}" >       
       {{ $dep->dep_o_ent }}
       </option>
       @endforeach
</select> 

<select name="unidades" id="unidades" disabled>
       @foreach($unidad as $uni)
       <option value="{{ $unidad_ini }}" >       
       {{ $uni->unidad_admva }}
       </option>
       @endforeach 
</select> 
<select name="areas" id="areas" disabled>
       @foreach($area as $are)
       <option value="{{ $area_ini }}" >
       {{ $are->area }}
       </option>
       @endforeach            
</select> 
</p>