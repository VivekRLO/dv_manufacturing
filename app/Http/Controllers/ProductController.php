<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Flash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $products = Product::where('flag', 0)->paginate(100);
        $brands = $products->unique('brand_name');
        $brands_name = $brands->pluck('brand_name');
        
        return view('products.index',[
            'products' => $products,
            'brands_name' => $brands_name,
        ]);
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input['name'] = $request->name;
        $input['brand_name'] = $request->brand_name;
        $input['unit'] = $request->unit;
        $input['value'] = $request->value;
        if ($request->hasFile('catalog')) {
            $file = $request->file('catalog');
            $extension = $request->file('catalog')->getClientOriginalExtension();
            $fileNameWithExt = $request->file('catalog')->getClientOriginalName();
            $filename_temp = preg_replace('/[^a-zA-Z0-9_-]+/', '', pathinfo($fileNameWithExt, PATHINFO_FILENAME));
            $filename = $filename_temp . '_' . time() . '.' . $extension;
            $input['catalog'] = 'public/storage/catalog/' . $filename;
            $file->storeAs('catalog', $filename, 'public');
            // dd($input);
        }
        $product = $this->productRepository->create($input);

        Flash::success('Product saved successfully.');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified Product in storage.
     *
     * @param int $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }
        $input['name'] = $request->name;
        $input['brand_name'] = $request->brand_name;
        $input['unit'] = $request->unit;
        $input['value'] = $request->value;
        if ($request->hasFile('catalog')) {
            $file = $request->file('catalog');
            $extension = $request->file('catalog')->getClientOriginalExtension();
            $fileNameWithExt = $request->file('catalog')->getClientOriginalName();
            $filename_temp = preg_replace('/[^a-zA-Z0-9_-]+/', '', pathinfo($fileNameWithExt, PATHINFO_FILENAME));
            $filename = $filename_temp . '_' . time() . '.' . $extension;
            $input['catalog'] = 'public/storage/catalog/' . $filename;
            $file->storeAs('catalog', $filename, 'public');
            // dd($input);
        }
        // dd($input);
        $product = $this->productRepository->update($input, $id);

        Flash::success('Product updated successfully.');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }
        $input['flag'] = 1;
        $this->productRepository->update($input, $id);

        Flash::success('Product deleted successfully.');

        return redirect(route('products.index'));
    }

    public function fileImportExport()
    {
        // return 'f';
        return view('products.bulk_create');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
       
        $validated = $request->validate([
            'productExcel' => 'required|mimes:csv,xlsx',
        ]);
        Excel::import(new ProductsImport, $request->file('productExcel')->store('temp'));
        Flash::success('Product import successfully.');

        return redirect(route('products.index'));
    }

    public function product_filter(Request $request)
    {
        $from = $request->mrp_from;
        $to = $request->mrp_to;
        $brand = $request->filtername;

        $products = Product::where('flag', 0)->get();
        $brands = $products->unique('brand_name');
        $brands_name = $brands->pluck('brand_name');

        $min = Product::min('value');
        $max = Product::max('value');

        if($brand == null){
            $products = Product::whereBetween('value', [$from??$min, $to??$max])->paginate(100);
        }else{
            $products = Product::where('brand_name', $brand)->whereBetween('value', [$from??$min, $to??$max])->paginate(100);
        }

        return view('products.index',[
            'products' => $products,
            'brands_name' => $brands_name,
        ]);

    }

    public function product_filter_by_id($id)
    {
        $products = Product::where('flag', 0)->get();
        
        $brands = $products->unique('brand_name');
        $brands_name = $brands->pluck('brand_name');

        $products = Product::where('id', $id)->paginate(100);
        return view('products.index',[
            'products' => $products,
            'brands_name' => $brands_name,
        ]);

    }
}
