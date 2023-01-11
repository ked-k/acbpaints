<style>
    @media print{

.noprint {
    display:none;
}



}

</style>
<div class="sidebar-wrapper noprint" data-simplebar="true">


    <div class="sidebar-header noprint">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{$appName}}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu noprint" id="menu">


        <li class="menu-label">
        {{-- @foreach(Session::get('branchdata') as $data)
            <span class="text-primary"><i class='bx bx-current-location'></i>{{ $data->location_name}} </span>
        @endforeach</li> --}}
        <span class="text-primary"><i class='bx bx-current-location'></i>{{ Session::get('branchname') }} </span>
        </li>

        <li>
            <a href="{{url('inventory/dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Manage Sales</div>
            </a>
            <ul>

                <li> <a href="{{url('inventory/sale/new/MSL'.mt_rand(1000, 9999).time())}}" class="btn btn-primary" ><i class="bx bx-right-arrow-alt"></i>New Store Sale</a>
                </li>
                {{-- <li> <a href="{{url('inventory/sale/invoice/INVSL'.mt_rand(1000, 9999).time())}}"><i class="bx bx-right-arrow-alt"></i>New invoice</a>
                </li> --}}
                <li> <a href="{{url('inventory/sale/machine/MCHSL'.mt_rand(1000, 9999).time())}}"><i class="bx bx-right-arrow-alt"></i>New Machine Sale</a>
                </li>
                <li> <a href="{{url('inventory/sale/tabe/TBLSL'.mt_rand(1000, 9999).time())}}"><i class="bx bx-right-arrow-alt"></i>New Table Sale</a>
                </li>
                <li> <a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Sales History</a>
                    <ul>
                        <li> <a href="{{url('inventory/history/main')}}"><i class="bx bx-right-arrow-alt"></i>All Sales</a>
                        </li>
                        <li> <a href="{{url('inventory/history/transfer')}}"><i class="bx bx-right-arrow-alt"></i>Transfer History</a>
                        </li>

                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-box'></i>
                </div>
                <div class="menu-title">Manage products</div>
            </a>
            <ul>
                <li> <a href="{{url('inventory/items')}}"><i class="bx bx-right-arrow-alt"></i>Product List</a>
                </li>
                <li> <a href="{{url('inventory/item/new')}}"><i class="bx bx-right-arrow-alt"></i>New Product</a>
                </li>

            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-location-plus"></i>
                </div>
                <div class="menu-title">Manage Locations</div>
            </a>
            <ul>
                <li> <a href="{{url('inventory/branches')}}"><i class="bx bx-right-arrow-alt"></i>Branches</a>
                </li>

            </ul>
        </li>

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon icon-color-11"><i class="bx bx-menu"></i>
                </div>
                <div class="menu-title">Manage Stock</div>
            </a>
            <ul>
                <li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Main stock</a>
                    <ul>
                        <li> <a href="{{url('inventory/stockLevels')}}"><i class="bx bx-right-arrow-alt"></i>Main Stock Levels</a>
                        </li>
                        <li> <a href="{{url('inventory/stock/new/MS'.mt_rand(1000, 9999).time())}}"><i class="bx bx-right-arrow-alt"></i>New stock Doc</a>
                        </li>
                        <li> <a href="{{url('inventory/stock/documents')}}"><i class="bx bx-right-arrow-alt"></i>Main Stock Docs</a>
                        </li>

                    </ul>
                </li>
                <li> <a  href="{{url('inventory/machine/stockLevels')}}"><i class="bx bx-right-arrow-alt"></i>Machine stock</a>
                    {{-- <ul>
                        <li> <a href="{{url('inventory/machine/stockLevels')}}"><i class="bx bx-right-arrow-alt"></i>Machine Stock levels</a>
                        </li>
                        <li> <a href="{{url('inventory/machine/stock/documents')}}"><i class="bx bx-right-arrow-alt"></i>Stock Docs</a>
                        </li>

                    </ul> --}}
                </li>
                <li> <a  href="{{url('inventory/table/stockLevels')}}"><i class="bx bx-right-arrow-alt"></i>Table stock</a>
                    {{-- <ul>
                        <li> <a href="{{url('inventory/table/stockLevels')}}"><i class="bx bx-right-arrow-alt"></i>Table Stock levels</a>
                        </li>
                        <li> <a href="{{url('inventory/table/stock/documents')}}"><i class="bx bx-right-arrow-alt"></i>Table Stock Docs</a>
                        </li>

                    </ul> --}}
                </li>
            </ul>
        </li>
        {{-- <li class="menu-label">Others</li> --}}

        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Customers/Suppliers</div>
            </a>
            <ul>
                <li> <a href="{{url('inventory/suppliers')}}"><i class="bx bx-right-arrow-alt"></i>Suppliers</a>
                </li>
                <li> <a href="{{url('inventory/customers')}}"><i class="bx bx-right-arrow-alt"></i>Customers</a>
                </li>
            </ul>
        </li>
   <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-briefcase-alt"></i>
                </div>
                <div class="menu-title">Manage Transaction</div>
            </a>
            <ul>
                <li> <a href="{{url('inventory/deposit/new')}}"><i class="bx bx-right-arrow-alt"></i>Customer Deposit</a></li>
                <li> <a href="{{url('inventory/withdraw/new')}}"><i class="bx bx-right-arrow-alt"></i>Customer Withdraw</a>
                </li>
                <li> <a href="{{url('inventory/customer/transactions')}}"><i class="bx bx-right-arrow-alt"></i>Customer Transactions</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{url('inventory/units')}}">
                <div class="parent-icon"> <i class="bx bx-folder-plus"></i>
                </div>
                <div class="menu-title">Categories</div>
            </a>
        </li>

        <li>
            <a href="{{url('inventory/Subunits')}}">
                <div class="parent-icon"><i class="bx bx-grid-alt"></i>
                </div>
                <div class="menu-title">Subcategories</div>
            </a>
        </li>
        <li>
            <a href="{{url('inventory/uom')}}">
                <div class="parent-icon"><i class="lni lni-weight"></i>
                </div>
                <div class="menu-title">UOM</div>
            </a>
        </li>
    
        @role('superadministrator','administrator')
        <li>
            <a href="{{url('inventory/expenditures')}}">
                <div class="parent-icon"><i class="bx bx-file"></i>
                </div>
                <div class="menu-title">Expenditures</div>
            </a>
        </li>
        @endrole
@role('superadministrator')
<li>
    <a href="{{url('inventory/reports')}}">
        <div class="parent-icon"><i class="bx bx-file"></i>
        </div>
        <div class="menu-title">Reports</div>
    </a>
</li>

        <li>
            <a href="{{url('management/dashboard')}}">
                <div class="parent-icon"><i class="bx bx-user-plus"></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        @endrole
        <li>
            <a target="_blank" href="https://support.ripontechug.com/rpos" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
