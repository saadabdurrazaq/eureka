<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return \App\Product::latest()->get();
    }

    public function map($product): array
    {
        $elements = [];
        foreach ($product->category as $v) {
            $elements[] = $v->name;
        }
        $res = implode(', ', $elements);

        return [
            $product->id,
            $product->product_code,
            $product->name,
            $res,
            $product->stok->jumlah_barang
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Product Code',
            'Product Name',
            'Categories',
            'Stok'
        ];
    }
}
