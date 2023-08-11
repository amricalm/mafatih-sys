<div class="row">
    <div class="col-md-12">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="nip">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" autocomplete="off" placeholder="Nomor Induk Pegawai" value="">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Nama Lengkap" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="name_ar">Nama Lengkap Dalam Huruf Arab</label>
            <input type="text" class="form-control arabic" name="name_ar" id="name_ar" autocomplete="off" dir="rtl" placeholder="بالعربية" >
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="nik">NIK di KK</label>
            <input type="text" class="form-control" name="nik" autocomplete="off" placeholder="NIK yang tertera di KK">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="kk">Nomor Kartu Keluarga</label>
            <input type="text" class="form-control" name="kk" autocomplete="off" placeholder="Nomor Kartu Keluarga">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="pob">Tempat Lahir</label>
            <input type="text" class="form-control" name="pob" autocomplete="off" required placeholder="Tempat Lahir">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="dob">Tanggal Lahir</label>
            <input type="text" class="form-control datepicker" name="dob" autocomplete="off" required placeholder="1999-09-19">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="">Jenis Kelamin</label>
            <br>
            @php
            $array = ['L'=>'Laki-laki','P'=>'Perempuan'];
            $i = 0;
            foreach($array as $key=>$val) {
            $i++;
            echo '<input type="radio" name="sex" id="sex'.$i.'" value="'.$key.'" required> <label for="sex'.$i.'">'.$val.'</label>&nbsp;&nbsp;';
            }
            @endphp
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="citizen">Kewarganegaraan</label>
            <input type="text" class="form-control" autocomplete="off" name="citizen" id="citizen" value="WNI">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="religion">Agama</label>
            <select name="religion" id="religion" class="form-control">
                @php
                $arrayr = ['islam'=>'Islam','lainnya'=>'lainnya'];
                foreach($arrayr as $key=>$val)
                {
                echo '<option value="'.$key.'">'.$val.'</option>';
                }
                @endphp
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="ibu_nama">Nama Ibu Kandung</label>
            <input type="text" class="form-control" autocomplete="off" name="ibu_nama" id="ibu_nama" placeholder="Nama Lengkap Ibu Kandung">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-control-label" for="address">Alamat Rumah</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="18"></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="provinsi">Provinsi</label>
            <select class="form-control" name="provinsi" id="provinsi" required>
                <option value="0"> - Pilih Salah Satu - </option>
                @foreach ($provinces as $item)
                <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="kota">Kota</label>
            <select class="form-control" name="kota" id="kota" required>
                <option value="0"> - Pilih Salah Satu - </option>
            </select>
        </div>
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="kecamatan">Kecamatan</label>
            <select class="form-control" name="kecamatan" id="kecamatan" required>
                <option value="0"> - Pilih Salah Satu - </option>
            </select>
        </div>
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="desa">Desa</label>
            <select class="form-control" name="desa" id="desa" required>
                <option value="0"> - Pilih Salah Satu - </option>
            </select>
        </div>
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="post">Kode POS</label>
            <input type="text" class="form-control" name="post" id="post" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="latitude">Lintang</label>
            <input type="text" class="form-control" name="latitude" id="latitude" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="longitude">Bujur</label>
            <input type="text" class="form-control" name="longitude" id="longitude" autocomplete="off">
        </div>
    </div><div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="last_education">Pendidikan Terakhir</label>
            <input type="text" class="form-control" name="last_education" id="last_education" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="phone">Nomor Telepon Rumah</label>
            <input type="text" class="form-control" name="phone" id="phone" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="hp">Nomor HP</label>
            <input type="text" class="form-control" name="hp" id="hp" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="email">E-Mail</label>
            <input type="email" class="form-control" name="email" id="email" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="npwp">NPWP</label>
            <input type="text" class="form-control" name="npwp" id="npwp" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="npwp_name">Nama Wajib Pajak</label>
            <input type="text" class="form-control" name="npwp_name" id="npwp_name" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group input-group-sm">
            <label class="form-control-label" for="marital_status">Status Pernikahan</label>
            <select name="marital_status" id="marital_status" class="form-control">
                <option value="0"> - Pilih Salah Satu - </option>
                @php
                $arrayr = ['Menikah'=>'Menikah','Belum Menikah'=>'Belum Menikah'];
                foreach($arrayr as $key=>$val)
                {
                    echo '<option value="'.$key.'">'.$val.'</option>';
                }
                @endphp
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group input-group-sm text-right">
            <button type="button" class="btn btn-secondary"><i class="fa fa-undo"></i> Kembali</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
</div>
