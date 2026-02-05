<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GetProductFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GetChildCategoriesBySubcategoryId;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\CreateProduct;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\ViewAllProducts;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\DeleteProduct;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GetProductForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\UpdateProduct;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\ViewAllProductReviews;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\ApproveProductReview;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\DeleteProductReview;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GetProductReviewInfo;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\SubmitReplyOfProductReview;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GetVariantFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\DeleteProductVariant;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\ViewAllQuestionAnswer;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\DeleteQuestionAnswer;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GetQuestionAnswerInfo;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\SubmitAnswerOfQuestion;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\GenerateDemoProducts;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions\RemoveDemoProducts;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/Products');
    }

    public function addNewProduct()
    {
        $result = GetProductFormData::execute(request());
        return view('create', $result['data']);
    }

    public function childcategorySubcategoryWise(Request $request)
    {
        $result = GetChildCategoriesBySubcategoryId::execute($request);
        return response()->json($result['data']);
    }

    public function saveNewProduct(Request $request)
    {
        $result = CreateProduct::execute($request);

        if ($result['status'] === 'success') {
            Toastr::success($result['message'], 'Success');
        } else {
            Toastr::error($result['message'], 'Error');
        }

        return back();
    }

    public function viewAllProducts(Request $request)
    {
        $result = ViewAllProducts::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view('view');
    }

    public function deleteProduct($slug)
    {
        $result = DeleteProduct::execute(request(), $slug);
        return response()->json(['success' => $result['message'], 'data' => $result['data']]);
    }

    public function editProduct($slug)
    {
        $result = GetProductForEdit::execute(request(), $slug);
        return view('update', $result['data']);
    }

    public function updateProduct(Request $request)
    {
        $result = UpdateProduct::execute($request);

        if ($result['status'] === 'success') {
            Toastr::success($result['message'], 'Success');
            return redirect()->route('ViewAllProducts');
        } else {
            Toastr::error($result['message'], 'Error');
            return back();
        }
    }

    public function viewAllProductReviews(Request $request)
    {
        $result = ViewAllProductReviews::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view('reviews');
    }

    public function approveProductReview($slug)
    {
        $result = ApproveProductReview::execute(request(), $slug);
        return response()->json(['success' => $result['message']]);
    }

    public function deleteProductReview($slug)
    {
        $result = DeleteProductReview::execute(request(), $slug);
        return response()->json(['success' => $result['message']]);
    }

    public function addAnotherVariant()
    {
        $result = GetVariantFormData::execute(request());
        $returnHTML = view('variant', $result['data'])->render();
        return response()->json(['variant' => $returnHTML]);
    }

    public function deleteProductVariant($id)
    {
        $result = DeleteProductVariant::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function getProductReviewInfo($id)
    {
        $result = GetProductReviewInfo::execute(request(), $id);
        return response()->json($result['data']);
    }

    public function submitReplyOfProductReview(Request $request)
    {
        $result = SubmitReplyOfProductReview::execute($request);
        return response()->json(['success' => $result['message']]);
    }

    public function viewAllQuestionAnswer(Request $request)
    {
        $result = ViewAllQuestionAnswer::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view('questions');
    }

    public function deleteQuestionAnswer($id)
    {
        $result = DeleteQuestionAnswer::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function getQuestionAnswerInfo($id)
    {
        $result = GetQuestionAnswerInfo::execute(request(), $id);
        return response()->json($result['data']);
    }

    public function submitAnswerOfQuestion(Request $request)
    {
        $result = SubmitAnswerOfQuestion::execute($request);
        return response()->json(['success' => $result['message']]);
    }

    public function generateDemoProducts()
    {
        return view('generate_demo');
    }

    public function saveGeneratedDemoProducts(Request $request)
    {
        $result = GenerateDemoProducts::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function removeDemoProductsPage()
    {
        return view('remove_demo');
    }

    public function removeDemoProducts()
    {
        $result = RemoveDemoProducts::execute(request());
        Toastr::success($result['message'], 'Success');
        return back();
    }
}
