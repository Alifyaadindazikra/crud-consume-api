<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //mengambil data dri input search
        $search = $request->search;
        //memanggil libraries BaseApi methodnya index dengan menngirim prameteri berupa path data dri API nya, parameter2 data untuk mengisi searc_nama api nya
        //BaseApi file dri libraries 

        $data = (new BaseApi)->index('/api/students',['search_nama' => $search]);//ngirim request ke project api
        //ambil response jsonnya
        $students = $data->json();//data di ambil bentuk json $data=newbaseAPI
        //dd($students);
        //kirim hasil pengambilan data ke blade index
        return view('index')->with(['students' =>$students['data']]);//ngirim data student 'students' disamain sma index, dat adari josn tadi ( data json dri properti data)
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =[
            'nama'=>$request->nama,
            'nis'=>$request->nis,
            'rombel'=>$request->rombel,
            'rayon'=>$request->rayon,
        ];
        $proses = (new BaseApi)->store('/api/students/tambah-data', $data);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil menambahkan data baru ke students API');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // proses ambil data api ke route REST API /students/{id}
        $data = (new BaseApi)->edit('/api/students/' .$id);// . nyambungin rute student ke rute id dan variabel ()
        if ($data->failed()) {
            // kalau gagal proses $data diatas, ambil deksripsi error dari json property data
            $errors = $data->json('data');
            // balikin ke halaman awal, sama errors nya
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // kalau berhasil, ambil data dari json nya
            $student = $data->json(['data']);
            // alihin ke blade edit dengan mengirim data $student diatas agar bisa digunakan pada blade
            return view('edit')->with(['student' => $student]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//ngmbil dta dri inputan form yg dibikin di blade
    {
        //data yang dikirim($request ke rest apinya)
        $payload = [
            'nama' => $request->nama,
            'nis'=>$request->nis,
            'rombel' => $request->rombel,
            'rayon' =>$request->rayon,
        ];
        //panggil method update dari baseapi, kirim ednpoint(route dari rest api)
        $proses = (new BaseApi)->update('/api/students/update/'.$id, $payload);// , buat misahin nilai 1 dan 2
        if ($proses->failed()) {
            //kalau gagal, balikin lagi sma psan errors dri jsonnya
            $errors= $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else{
            //berhasil, balikin ke halaman paling awal dengan pesan
            return redirect('/')->with('success', 'Berhasil mengubah data siswa dari API');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proses = (new BaseApi)->delete('/api/students/delete/'.$id);
        if ($proses->failed()) {
            //kalau gagal, balikin lagi sma psan errors dri jsonnya
            $errors= $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else{
            //berhasil, balikin ke halaman paling awal dengan pesan
            return redirect('/')->with('success', 'Berhasil hapus data sementara dari API');
        }
        
        
    }
    public function trash(){
        $proses = (new BaseApi)->trash('/api/students/show/trash/');//trash=function
        if ($proses->failed()) {
            //kalau gagal, balikin lagi sma psan errors dri jsonnya
            $errors= $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else{
            $studentsTrash = $proses->json('data');
            return view('trash')->with(['studentsTrash' =>$studentsTrash]);
        }
    }
    public function permanent($id){
        $proses = ( new BaseApi)->permanent('/api/students/trash/delete/permanent/'.$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect()->back()->with('success', 'Berhasil menghapus data secara permanent');
        }
    }
    public function restore($id)
    {
        $proses = (new BaseApi)->restore('/api/students/trash/restore/'.$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil mengembalikan data dari sampah');
        }

    }
}
