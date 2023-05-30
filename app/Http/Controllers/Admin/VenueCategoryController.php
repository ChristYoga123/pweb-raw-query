<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VenueCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VenueCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.admin.kategori-venue.index")->with([
            "categories" => DB::select("SELECT * FROM venue_categories")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.admin.kategori-venue.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:venues,name"
        ]);

        DB::beginTransaction();
        try {
            DB::insert("INSERT INTO venue_categories(name, slug) VALUES(?, ?)", [$request->name, Str::slug($request->name)]);
            DB::commit();
            return redirect()->route("admin.kategori_venue.index")->with("success", "Data berhasil disimpan");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VenueCategory $venueCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VenueCategory $kategori_venue)
    {
        $venueCategory = DB::select("SELECT * FROM venue_categories WHERE slug=(?) LIMIT 1", [$kategori_venue->slug]);
        return view("pages.admin.kategori-venue.edit")->with([
            "venue_category" => $venueCategory[0]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VenueCategory $kategori_venue)
    {
        $request->validate([
            "name" => "required|unique:venue_categories,name," . $kategori_venue->id
        ]);
        DB::beginTransaction();
        try {
            DB::update("UPDATE venue_categories SET name = ?, slug = ? WHERE slug = ?", [$request->name, Str::slug($request->name), $kategori_venue->slug]);
            DB::commit();
            return redirect()->route("admin.kategori_venue.index")->with("success", "Data berhasil diubah");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VenueCategory $kategori_venue)
    {
        try {
            DB::delete("DELETE FROM venue_categories WHERE slug = ?", [$kategori_venue->slug]);
            return redirect()->back()->with("success", "Data berhasil dihapus");
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
}
