<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MongoDB\Driver\Session;

class ListingController extends Controller
{
  public function index () {
      //dd(request('tag'));
      return view('listings.index', [
          'listings' => Listing::latest()
              ->filter(\request(['tag', 'search']))
              ->paginate(8) //cik radit vienaa lapaa (tas ir ar Tailwind palidzibu)
            // ->simplePaginate(2) Ja grib ar PREVIOUS/NEXT page
          // ja grib modificet lapu pagination stilu, vajag: php artisan vendor:publish
      ]);
  }

  public function show (Listing $listing) {
      return view('listings.show', [
          'listing' => $listing
      ]);
  }

  public function create  () {
      return view('listings.create');
  }

  public function store(Request $request) {
      $formFields = $request->validate([
          'title' => 'required',
          'company' => ['required', Rule::unique('listings', 'company')],
          'location' => 'required',
          'website' => 'required',
          'email' => ['required','email'],
          'tags' => 'required',
          'description' => 'required'
      ]);

      if($request->hasFile('logo')) {
          $formFields['logo']=$request
              ->file('logo')
              ->store('logos', 'public');
      }
      $formFields['user_id'] = auth()->id();

      Listing::create($formFields);

      return redirect('/')->with('message', 'Listing created successfully!');
  }

  public function edit(Listing $listing) {
      return view('listings.edit', ['listing' => $listing]);
  }

    public function update(Request $request, Listing $listing) {

      //make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo']=$request
                ->file('logo')
                ->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing) {

        //make sure logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

    $listing->delete();
    return redirect('/')->with('message', 'Listing Deleted successfully');
    }

    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
