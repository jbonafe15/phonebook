<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phonebook;
use App\Models\Header;

class PhonebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $phonebooks = Phonebook::all();
        $headers = Header::all();
        $search = '';
        if ($request->hasAny(['search'])) {
            if ($request->filled('search') || $request->filled('search')) {
                $phonebooks = Phonebook::where('firstname', $request->search)
                    ->orWhere('lastname', $request->search)
                    ->orWhere('mobile', $request->search)
                    ->get();
            }
            $search = $request->search;
        }
        return view('phonebooks.index')
            ->with('phonebooks', $phonebooks)
            ->with('headers', $headers)
            ->with('search', $search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file->extension() != 'csv') {
            return redirect()->back()->with(['message' => 'File must be csv extension']);
        }
        $file = fopen($request->file, "r");
        $data = fgetcsv($file);
        while(($data = fgetcsv($file, 1000, ",")) !== false) {
            Phonebook::create([
                'title' => $data[$request->header[0]],
                'firstname' => $data[$request->header[1]],
                'lastname' => $data[$request->header[2]],
                'mobile' => $data[$request->header[3]],
                'company' => $data[$request->header[4]]
            ]);
        }
        
        fclose($file);

        return redirect()->back()->with(['message' => 'Import Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phonebook = Phonebook::find($id);
        return view('phonebooks.show')->with('phonebook', $phonebook);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phonebook = Phonebook::find($id);
        return view('phonebooks.edit')->with('phonebook', $phonebook);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $phonebook = Phonebook::find($id);
        $input = $request->all();
        $phonebook->update($input);
        return redirect('phonebook')->with('flash_message', 'Phonebook Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Phonebook::destroy($id);
        return redirect('phonebook')->with('flash_message', 'Phonebook deleted!');
    }
}
