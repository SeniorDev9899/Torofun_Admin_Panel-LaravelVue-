<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['id', 'itemName', 'itemFunctionName', 'itemUrl', 'inOffer', 'isNew', 'itemPrice', 'itemOriginalPrice', 'gender', 'isPurchased', 'subCategoryId', 'categoryId'];
}
