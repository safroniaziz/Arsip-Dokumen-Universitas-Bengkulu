<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\KlasifikasiBerkas;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OperatorBerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $berkas = Berkas::join('users','users.id','berkas.operator_id')
                        ->join('units','units.id','users.unit_id')
                        ->select('berkas.id as id','berkas.nomor_berkas','klasifikasi_id','nm_unit','jenis_berkas','berkas.created_at','file','nm_user as nm_operator','nm_unit','uraian_informasi')
                        ->where('units.id',Auth::user()->unit_id)
                        ->orderBy('berkas.id','desc')->get();
        return view('operator/berkas.index',compact('berkas'));
    }

    public function add(){
        $klasifikasis = KlasifikasiBerkas::where('status','aktif')->get();
        return view('operator/berkas.add',compact('klasifikasis'));
    }

    public function post(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
            'mimes' => 'The :attribute harus berupa file: :values.',
            'max' => [
                'file' => ':attribute tidak boleh lebih dari :max kilobytes.',
            ],
        ];
        $attributes = [
            'nomor berkas'   =>  'Nomor berkas',
            'jenis_berkas'   =>  'Jenis berkas',
            'klasifikasi_id'   =>  'Klasifikasi Berkas',
            'file'   =>  'File',
            'uraian_informasi'   =>  'Uraian Informasi',
        ];
        $this->validate($request, [
            'nomor_berkas'    =>  'required',
            'jenis_berkas'    =>  'required',
            'klasifikasi_id'    =>  'required',
            'file'    =>  'required|mimes:doc,pdf,docx,jpg|max:2000',
            'uraian_informasi'    =>  'required',
        ],$messages,$attributes);
        
        $model = $request->all();
        $model['file'] = null;
        $nama_unit = Unit::where('id',Auth::user()->unit_id)->select('nm_unit')->first();
        $slug = Str::slug($nama_unit->nm_unit);
        $slug_user = Str::slug(Auth::user()->nm_user);
        
        $tags = $request->input('klasifikasi_id');

        if ($request->hasFile('file')) {
            $model['file'] = $slug.'-'.$slug_user.'-'.date('now').$model['nomor_berkas'].'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('/upload_file/'.$slug), $model['file']);
        }
        Berkas::create([
            'nomor_berkas'    =>    $request->nomor_berkas,  
            'jenis_berkas'    =>    $request->jenis_berkas,  
            'klasifikasi_id'    =>  implode(',',$tags),  
            'file'    =>    $model['file'],  
            'uraian_informasi'    =>    $request->uraian_informasi,  
            'operator_id'   =>  Auth::user()->id,
            'unit_id'       =>  Auth::user()->unit_id,
        ]);
        $notification = array(
            'message' => 'Berhasil, berkas berhasil ditambahkan!',
            'alert-type' => 'success'
        );
        
        return redirect()->route('operator.berkas')->with($notification);
    }

    public function edit($id){
        $berkas = Berkas::find($id);
        $klasifikasis = KlasifikasiBerkas::where('status','aktif')->get();
        $item_klasifikasi = explode(',',$berkas->klasifikasi_id);
        return view('operator/berkas.edit',compact('berkas','klasifikasis','item_klasifikasi'));
    }

    public function update(Request $request){
        $messages = [
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus angka',
            'mimes' => 'The :attribute harus berupa file: :values.',
            'max' => [
                'file' => ':attribute tidak boleh lebih dari :max kilobytes.',
            ],
        ];
        $attributes = [
            'nomor berkas'   =>  'Nomor berkas',
            'jenis_berkas'   =>  'Jenis berkas',
            'klasifikasi_id'   =>  'Klasifikasi Berkas',
            'file'   =>  'File',
            'uraian_informasi'   =>  'Uraian Informasi',
        ];
        $this->validate($request, [
            'nomor_berkas'    =>  'required',
            'jenis_berkas'    =>  'required',
            'klasifikasi_id'    =>  'required',
            'file'    =>  'mimes:doc,pdf,docx,jpg|max:2000',
            'uraian_informasi'    =>  'required',
        ],$messages,$attributes);
        
        $file = Berkas::find($request->id);
        $model = $request->all();
        $model['file'] = $file->file;
        $nama_unit = Unit::where('id',Auth::user()->unit_id)->select('nm_unit')->first();
        $slug = Str::slug($nama_unit->nm_unit);
        $slug_user = Str::slug(Auth::user()->nm_user);

        $tags = $request->input('klasifikasi_id');

        DB::beginTransaction();
        try {
            if ($request->hasFile('file')){
                if (!$file->file == NULL){
                    unlink(public_path('/upload_file/'.Str::slug($slug).'/'.$file->file));
                }
                $model['file'] = $slug.'-'.$slug_user.'-'.date('now').$model['nomor_berkas'].'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path('/upload_file/'.$slug), $model['file']);
            }

            Berkas::where('id',$request->id)->update([
                'nomor_berkas'    =>    $request->nomor_berkas,  
                'jenis_berkas'    =>    $request->jenis_berkas,  
                'klasifikasi_id'    =>  implode(',',$tags), 
                'file'    =>    $model['file'],
                'uraian_informasi'    =>    $request->uraian_informasi,  
                'operator_id'   =>  Auth::user()->id,
                'unit_id'       =>  Auth::user()->unit_id,
            ]);
            DB::commit();
            $berhasil = array(
                'message' => 'Berhasil, berkas berhasil diubah!',
                'alert-type' => 'success'
            );
            return redirect()->route('operator.berkas')->with($berhasil);
        } catch (\Exception $e) {
            DB::rollback();
            $gagal = array(
                'message' => 'Gagal, berkas gagal diubah!',
                'alert-type' => 'error'
            );
            return redirect()->route('operator.berkas')->with($gagal);
            
        }
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try {
            $berkas = Berkas::join('users','users.id','berkas.operator_id')
                            ->join('units','units.id','users.unit_id')
                            ->select('berkas.id','nm_unit','file')
                            ->where('berkas.id',$request->id)
                            ->first();
                            // return $berkas;
            $slug = Str::slug($berkas->nm_unit);
            $slug_user = $berkas->nm_user;
            $path = \public_path('upload_file/'.$slug.'/'.$berkas->file);
            if(File::exists($path)) {
                unlink($path);
            }
            $berkas = Berkas::find($request->id);
            $berkas->delete();
            DB::commit();
            $berhasil = array(
                'message' => 'Berhasil, berkas berhasil dihapus!',
                'alert-type' => 'success'
            );
            return redirect()->route('operator.berkas')->with($berhasil);
        } catch (\Exception $e) {
            DB::rollback();
            $gagal = array(
                'message' => 'Gagal, berkas gagal dihapus!',
                'alert-type' => 'error'
            );
            return redirect()->route('operator.berkas')->with($gagal);
            
        }
    }
}
