<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Contact;
use Psr\Container\NotFoundExceptionInterface;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactsController extends Controller
{
    public function index() {
        $contact = DB::table('contacts')->paginate(10);
        return view('Contact.ListContact')->with('contact', $contact);
    }

    public function create() {
        return view('Contact.AddContact');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'fullName' => 'required|max:20',
            'phoneNumber' => 'required|size:11',
            'address' => 'max:50',
            'note' => 'max:120',
            'birth_year' => 'required'
        ]);

        $contact = new Contact;
        $contact->fullName = $request->input('fullName');
        $contact->phoneNumber = $request->input('phoneNumber');
        $contact->address = $request->input('address');
        $contact->note = $request->input('note');
        $contact->birth_year = $request->input('birth_year');
        $contact->save();
        
        return redirect('/Contacts')->with('success', "Ekleme işlemi başarıyla gerçekleştirildi!");
    }

    public function show(Request $request){
        $contact = Contact::find($request->id);
        if($contact == null)
            abort(404);
        return json_encode($contact);
    }

    public function search(Request $request){ 
        $contact = Contact::where($request->SearchBy, 'LIKE', '%'.$request->SearchValue.'%')->get();
        return json_encode($contact);
    }

    public function edit($id) {
        $contact = Contact::find($id);
        if($contact == null)
            abort(404);
        return view('Contact.EditContact')->with('contact', $contact);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'fullName' => 'required|max:20',
            'phoneNumber' => 'required|size:11',
            'address' => 'max:50',
            'note' => 'max:120',
            'birth_year' => 'required'
        ]);

        $contact = Contact::find($id);
        $contact->fullName = $request->input('fullName');
        $contact->phoneNumber = $request->input('phoneNumber');
        $contact->address = $request->input('address');
        $contact->note = $request->input('note');
        $contact->birth_year = $request->input('birth_year');
        $contact->save();

        return redirect('/Contacts')->with('success', 'Güncelleme işlemi başarıyla gerçekleştirildi!');
    }

    public function destroy($id) {
        $contact = Contact::find($id);
        if($contact == null)
            abort(404);
        $contact->delete();
        return redirect('/Contacts')->with('success', "Silme işlemi başarıyla gerçekleştirildi!");
 
    }

    public function lang($lang){
        Session::put('locale', $lang);
        return redirect()->back();
    }

    
}
