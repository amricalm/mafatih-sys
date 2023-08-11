<table class="table data-table table-striped" id="tabeeel">
    <thead>
        <tr>
            <th>ID</th>
            <th>SBJ</th>
            <th>NIS</th>
            <th>NAMA</th>
            @php
                $tgs = \App\Models\GradeWeight::whereRaw('val != "0"')->join('rf_grade_type','type','=','code')->orderBy('seq')->get();
                $nama = '';
                foreach($tgs as $k=>$v):
                    $nama = ($v->type=='TGS') ? 'FORMATIF' : $v->type;
                    echo '<th>'.$nama.'</th>';
                endforeach;
            @endphp
        </tr>
    </thead>
    <tbody>
        @for($k=0;$k<count($alldata);$k++)
            <tr>
                <td>{{ $alldata[$k]->id }}</td>
                <td>{{ $alldata[$k]->sbj }}</td>
                <td>{{ $alldata[$k]->nis }}</td>
                <td>{{ $alldata[$k]->name }}</td>
                @php
                    if(count($isi)>0)
                    {
                        foreach($tgs as $kss=>$vss):
                            $isione = collect($isi)->where('sid',$alldata[$k]->id)->where('grade_type',$vss->type)->toArray();
                            $isione = reset($isione);
                            echo '<td>'.$isione['val'].'</td>';
                        endforeach;
                    }
                @endphp
            </tr>
        @endfor
    </tbody>
</table>

