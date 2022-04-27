<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use App\Item;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    // Main Category API Controller

    public function addCategory(Request $request){
        // validate request
        $this->validate($request, [
            'categoryName' => 'required'
        ]);
        return Category::create([
            'categoryName' => $request->categoryName
        ]);
    }
    public function editCategory(Request $request){
        // validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'id' => 'required',
        ]);
        return Category::where('id',$request->id)->update([
            'categoryName' => $request->categoryName
        ]);
    }
    public function deleteCategory(Request $request){
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id',$request->id)->delete();
    }
    public function getCategory(){
        return Category::orderBy('id','desc')->get();
    }

    // Sub Category API Controller

    public function getSubCategory(Request $request, $id){
        // $this->validate($request, [
        //     'categoryId' => 'required'
        // ]);
        return SubCategory::where('categoryId',$id)->get();
    }
    public function addSubCategory(Request $request){
        $this->validate($request, [
            'subCategoryName' => 'required',
            'categoryId' => 'required',
        ]);
        return SubCategory::create([
            'subCategoryName' => $request->subCategoryName,
            'categoryId' => $request->categoryId,
        ]);
    }
    public function editSubCategory(Request $request) {
        $this->validate($request, [
            'categoryId' => 'required',
            'id' => 'required',
        ]);
        return SubCategory::where('id',$request->id)->where('categoryId',$request->categoryId)->update([
            'subCategoryName' => $request->subCategoryName,
        ]);
    } 
    public function deleteSubCategory(Request $request) {
        $this->validate($request, [
            // 'id' => 'required',
            'categoryId' => 'required'
        ]);
        // return SubCategory::where('id',$request->id)->where('categoryId',$request->categoryId)->delete();
        return SubCategory::where('categoryId',$request->categoryId)->delete();
    }  

    public function deleteSubCategorySingle(Request $request) {
        $this->validate($request, [
            'id' => 'required',
        ]);
        return SubCategory::where('id',$request->id)->delete();
    }

    // Item API controller

    public function getItem(Request $request, $id) {
        // $this->validate($request, [
        //     'subCategoryId' => 'required'
        // ]);
        return Item::where('subCategoryId',$id)->get();
    }
    public function addItem(Request $request) {
        $this->validate($request, [
            'itemName' => 'required',
            'itemFunctionName' => 'required',
            'itemImage' => 'required',
            'itemInOffer' => 'required',
            'itemIsNew' => 'required', 
            'itemPrice' => 'required',
            'itemOriginalPrice' => 'required',
            'subCategoryId' => 'required',
            'categoryId'=>'required',
            'itemGender' => 'required',
            "itemPurchased" => 'required'
        ]);
        return Item::create([
            'itemName' => $request->itemName,
            'itemFunctionName' => $request->itemFunctionName,
            'itemUrl' => $request->itemImage,
            'inOffer' => $request->itemInOffer,
            'isNew' => $request->itemIsNew,
            'itemPrice' => $request->itemPrice,
            'itemOriginalPrice' => $request->itemOriginalPrice,
            'subCategoryId' => $request->subCategoryId,
            'categoryId' => $request->categoryId,
            'gender' => $request->itemGender,
            'isPurchased' => $request->itemPurchased

        ]);
    }
    public function editItem(Request $request) {
        $this->validate($request, [
            'subCategoryId' => 'required',
            'id' => 'required',
        ]);
        return Item::where('id',$request->id)->where('subCategoryId',$request->subCategoryId)->update([
            'itemName' => $request->itemName,
            'itemFunctionName' => $request->itemFunctionName,
            'itemUrl' => $request->itemImage,
            "inOffer" => $request->itemInOffer,
            'isNew' => $request->itemIsNew,
            "itemPrice" => $request->itemPrice,
            'itemOriginalPrice' => $request->itemOriginalPrice,
            'gender' => $request->itemGender,
            'isPurchased' => $request->itemPurchased
        ]);
    }
    public function deleteItem(Request $request) {
        $this->validate($request, [
            'id' => 'required',
            'subCategoryId' => 'required',
        ]);
        return Item::where('id',$request->id)->where('subCategoryId',$request->subCategoryId)->delete();
    }
    public function deleteItemCategory(Request $request) {
        $this->validate($request, [
            'categoryId' => 'required',
        ]);
        return Item::where('categoryId',$request->categoryId)->delete();
    }

    public function getAllContents() {
        $resposne = array();
        $categories = Category::orderBy('id','desc')->get();
        if(count($categories) > 0) {
            for($i = 0; $i < count($categories); $i++)
            {
                $subCategories = SubCategory::where('categoryId', $categories[$i]["id"])->get();
                if(count($subCategories) > 0) {
                    for($j = 0; $j < count($subCategories); $j++)
                    {
                        $items = Item::where('subCategoryId', $subCategories[$j]["id"])->get();
                        $info = ['category' => $categories[$i], 'subCategory' => $subCategories[$j], 'item' => $items];
                        $response[] = $info;
                    }
                }                
            }
        }
        
        return $response;
    }
}
