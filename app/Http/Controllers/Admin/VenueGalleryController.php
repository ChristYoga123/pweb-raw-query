<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VenueGallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VenueGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.admin.venue-gallery.index")->with([
            "galleries" => DB::select("SELECT venue_galleries.id, venue_galleries.gallery, venues.name as venue_name FROM venue_galleries JOIN venues ON venues.id = venue_galleries.venue_id")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.admin.venue-gallery.create")->with([
            "venues" => DB::select("SELECT * FROM venues")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "venue_id" => "required|integer|exists:venues,id",
            "gallery" => "required|image|mimes:png,jpg,jpeg"
        ]);

        DB::beginTransaction();
        try {
            $gallery = $request->file("gallery")->store("venue-gallery", "public");
            DB::insert("INSERT INTO venue_galleries(venue_id, gallery) VALUES(?, ?)", [$request->venue_id, $gallery]);
            DB::commit();
            return redirect()->route("admin.galeri_venue.index")->with("success", "Data berhasil ditambah");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VenueGallery $venueGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VenueGallery $venueGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VenueGallery $venueGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VenueGallery $galeri_venue)
    {
        Storage::delete("public/" . $galeri_venue->gallery);
        DB::delete("DELETE FROM venue_galleries WHERE id = ?", [$galeri_venue->id]);
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
