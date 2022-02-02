
<label for="periodo_ini">Periodo Inicial:</label>
     <select
            oninput="jsperiodos()"
            class="d-inline" name="periodo_ini" id="periodo_ini">
            @foreach($periodo as $per)
            <option value="{{ $periodo_ini }}" 
            <?php                   
                if( $per->cve_periodo == $periodo_ini) 
                    echo 'selected="selected"'                
            ?>                     
            > 
            {{ $per->cve_periodo." | ".$per->descripcion }}
            </option>
            @endforeach            
    </select>    
<label for="periodo_fin">,     Periodo Final:</label>
    <select 
            oninput="jsperiodos()"
            class="d-inline" name="periodo_fin" id="periodo_fin">
            @foreach($periodo as $per)
            <option value="{{ $periodo_fin }}" 
            <?php                   
                if( $per->cve_periodo == $periodo_fin) 
                    echo 'selected="selected"'                
            ?>                     
            > 
            {{ $per->cve_periodo." | ".$per->descripcion }}
            </option>
            @endforeach            
</select>
<p hidden>
<input type="hidden" id="periodoini" name= "periodoini" value="{{$periodo_ini}}">
<input type="hidden" id="periodofin" name= "periodofin" value="{{$periodo_fin}}">

<select name="periodos" id="periodos" disabled>
       @foreach($periodo as $per)
       <option value="{{ $periodo_ini }}" >       
       {{ $per->descripcion }}
       </option>
       @endforeach
</select> 

</p>

