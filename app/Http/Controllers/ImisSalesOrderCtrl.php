<?php

namespace App\Http\Controllers;

use App\Imis\ImisSalesOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImisSalesOrderCtrl extends Controller
{

    public function index(Request $request)
    {

    }

    public function getSalesOrderTypes(Request $request) {
        $mapped = [];

        $collection = ImisSalesOrder::getSalesOrderTypes('*');
        $mapped = $collection->map(function ($item, $key) {
            return [
                'GUID' => $item->GUID,
                'ArabicDescription' => $item->ArabicDescription,
            ];
        });
        return response()->json($mapped, 200);
    }


    public function getCurrencies(Request $request) {
        $mapped = [];

        $collection = ImisSalesOrder::getCurrencies('*');
        $mapped = $collection->map(function ($item, $key) {
            return [
                'GUID' => $item->GUID,
                'ArabicDescription' => $item->ArabicDescription,
            ];
        });
        return response()->json($mapped, 200);
    }

    public function insertSalesOrder(Request $request) {

        $sql = <<<EOD
        SET NOCOUNT ON ;
        DECLARE	@return_value int,
		@ID int,
		@GUID varchar(50)

EXEC	@return_value = [dbo].[SP_SalesOrder_Insert]
		@ID = @ID OUTPUT,
		@Code = '',
		@GUID = @GUID OUTPUT,
		@Company = 1,
		@SerialNo = '',
		@PaperNo = '',
		@Branch = 1,
		@OrderType = '01001-105C50CF-8CC5-4627-82B5-80DD3E660189',
		@OrderDate = :OrderDate,
		@BranchID = '1',
		@CustomerID = :CustomerID,
		@PaymentTermsDue = 0,
		@PaymentTermsAllowCash = 0,
		@PaymentTermsAllowCheque = 0,
		@PaymentTermsAllowBankTrans = 0,
		@PaymentTermsAllowPromiseNote = 0,
		@PaymentTermsAllowCreditCard = 0,
		@PaymentTermsInAdvancePayment = 0,
		@PaymentTermsInAdvanceType = 0,
		@PaymentTermsInAdvanceValue = 0,
		@PaymentTermsInstallment = 0,
		@CurrenceyID = '01001-D0DA0215-C43C-40F7-B63C-D0F46447DA7C',
		@CurrenceyRate = 1,
		@TaxID = '',
		@WareHouseID = '',
		@DiscountProfile = '',
		@DiscountPercent = 0,
		@ValidUpTo = '2021-10-21',
		@ShippingTermsID = '',
		@ShippingTypeID = '',
		@ShippingMethodID = '',
		@ShippingShipperID = '',
		@ShippingDate = '',
		@ShippingDeliveryDate = '',
		@ShippingPortID = '',
		@RFPNo = '',
		@RFPDate = '',
		@RFPSubject = '',
		@ApprovalByID = '',
		@ApprovalDate = NULL,
		@Hold = 0,
		@DownPaymentLink = '',
		@DownPaymentNo = '',
		@DownPaymentValue = 0,
		@TotalValue = 0,
		@TaxValue = 0,
		@ExpencesValue = 0,
		@DiscountValue = 0,
		@NetValue = 0,
		@SaleAccountID = '',
		@SaleJournalID = '',
		@SaleProjectID = '',
		@SaleDepartmentID = '',
		@SaleBudgetID = '',
		@SaleCostID = '',
		@InventoryAccountID = '',
		@InventoryJournalID = '',
		@InventoryProjectID = '',
		@InventoryDepartmentID = '',
		@InventoryBudgetID = '',
		@InventoryCostID = '',
		@SalesManID = '',
		@IsFirmed = '',
		@ConfirmationLevel = 0,
		@Notes = '',
		@DetailLine1 = '',
		@DetailLine2 = '',
		@DetailLine3 = '',
		@DetailLine4 = '',
		@DetailLine5 = '',
		@DetailLine6 = '',
		@DetailLine7 = '',
		@DetailLine8 = '',
		@DetailLine9 = '',
		@DetailLine10 = '',
		@CreatedBy = 1,
		@CreatedMacNo = 0,
		@Printed = 0

SELECT  @GUID as 'GUID'

SELECT	'Return Value' = @return_value ;

EOD;


        $results = DB::select($sql,[
            ':OrderDate' => Carbon::today()->toDateString(),
            ':CustomerID' => $request->CustomerID,
        ]);

        $collection = collect($results);
        $mapped = $collection->map(function($item, $key) {
            return [
                'GUID'=> $item->GUID,
            ];
        });
        return response()->json($mapped , 200);
    }

    public function insertSalesOrderDet(Request $request) {

        $sql = <<<EOD
        SET NOCOUNT ON ;
        DECLARE	@return_value int,
		@ID int,
		@GUID varchar(50)

EXEC	@return_value = [dbo].[SP_SalesOrderDet_Insert]
		@ID = @ID OUTPUT,
		@Code = '',
		@SerialCombination='',
		@WareHouseID = '',
		@WareHouseLocationID = '',
		@Company = 1,
		@Branch = 1,
		@GUID = @GUID OUTPUT,
		@HeadID = :HeadID,
		@ItemID = :ItemID,
		@Qnt = :Qnt,
		@UOMID = '01001-B6D649B3-2FC6-467D-BC63-07CDAF0F977B',
		@UomFactor = 1,
		@PriceCodeID = '',
		@PriceValue = 0,
		@TotalValue = 0,
		@DiscountPercent = 0,
		@DiscountValue = 0,
		@DiscountAccountID = '',
		@DiscountProjectID = '',
		@DiscountDepartmentID = '',
		@DiscountBudjetID = '',
		@DiscountJournalID = '',
		@DiscountCostCenterID = '',
		@TaxID = '',
		@TaxGroupId = '',
		@TaxValue = 0 ,
		@NetValue = 0 ,
		@TaxCalculated = 0,
		@ProductionDate = '',
		@ExpiringDate = '',
		@Notes = '',
		@PromotionId = '',
		@PromotionRowId= '',
		@IsFreeItem = 0,
		@TradeDiscountP = 0,
		@TradeDiscountV = 0,
		@ItemBalance = 0,
		@DeliveryDate = '',
		@CreatedBy = 1,
		@CreatedMacNo = 0

SELECT  @GUID as 'GUID'

SELECT	'Return Value' = @return_value;

EOD;

        $results = DB::select($sql,[
            ':HeadID' => $request->HeadID,
            ':ItemID' => $request->ItemID,
            ':Qnt' => $request->Qnt,
        ]);

        $collection = collect($results);
        $mapped = $collection->map(function($item, $key) {
            return [
                'GUID'=> $item->GUID,
            ];
        });
        return response()->json($mapped , 200);
    }

    public function insertSalesOrderDetSpec(Request $request) {

        $sql = <<<EOD
SET NOCOUNT ON ;
DECLARE	@return_value int,
		@ID int,
		@GUID varchar(50)

EXEC	@return_value = [dbo].[SP_SalesOrderSpecification_Insert]
		@ID = @ID OUTPUT,
		@Company = 1,
		@Branch = 1,
		@GUID = @GUID OUTPUT,
		@HeadId = :HeadID,
		@ElementId = :ElementId,
		@Value = :Value,
		@CreatedBy = 1,
		@CreatedMacNo = 0

SELECT  @GUID as 'GUID'

SELECT	'Return Value' = @return_value
EOD;

        $results = DB::select($sql,[
            ':HeadID' => $request->HeadID,
            ':ElementId' => $request->ElementId,
            ':Value' => $request->Value,
        ]);

        $collection = collect($results);
        $mapped = $collection->map(function($item, $key) {
            return [
                'GUID'=> $item->GUID,
            ];
        });
        return response()->json($mapped , 200);
    }

}
