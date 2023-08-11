<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Employe;
use App\Models\Person;
use App\Models\Address;
use App\Models\MsJobs;
use App\Models\MsConfig;
use App\Models\AcademicYear;
use App\Models\Sibling;
use App\Models\Achievement;
use App\Models\MedicalRecord;
use App\Models\School;
use App\Models\MsUpload;
use App\Models\Ppdb;
use Carbon\Carbon;
use DataTables;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $app = array();
        $app['person'] = Person::leftJoin('aa_student as b','b.pid','=','aa_person.id')
            ->leftJoin('aa_employe as c','c.pid','=','aa_person.id')
            ->leftJoin('aa_ppdb as d','d.pid','=','aa_person.id')
            ->select('aa_person.id','b.id as ids','c.id as ide','d.id as idp','name','name_ar')
            ->paginate(config('paging'));

        $app['aktif'] = 'person';
        $app['judul'] = "Person";

        return view('halaman.person', $app);
    }
}
