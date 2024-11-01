@php use App\Constants\ApplicationPermissionConstants;use App\Constants\ApplicationRoleConstants; @endphp
<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">

            @if(Auth::user()->roles->pluck('name')[0] == ApplicationRoleConstants::SuperAdmin)
                <li>
                    <a data-toggle="collapse" href="#tenants" {{ $section == 'tenants' ? 'aria-expanded=true' : '' }}>
                        <i class="tim-icons icon-badge"></i>
                        <span class="nav-link-text">Tenants</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ $section == 'tenants' ? 'aria-expanded=true' : '' }}" id="tenants">
                        <ul class="nav pl-4">
                            {{--<li @if ($pageSlug == 'tenants') class="active " @endif>
                                <a href="{{ route('tenants.edit')  }}">
                                    <i class="tim-icons icon-badge"></i>
                                    <p>Tenant profile</p>
                                </a>
                            </li>--}}
                            <li @if ($pageSlug == 'tenants-list') class="active " @endif>
                                <a href="{{ route('companies.index')  }}">
                                    <i class="tim-icons icon-notes"></i>
                                    <p>Manage Tenants</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'tenants-create') class="active " @endif>
                                <a href="{{ route('companies.create')  }}">
                                    <i class="tim-icons icon-simple-add"></i>
                                    <p>New tenant</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @else
                <li @if ($pageSlug == 'dashboard') class="active " @endif>
                    <a href="{{ route('home') }}">
                        <i class="tim-icons icon-chart-bar-32"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a data-toggle="collapse"
                       href="#transactions" {{ $section == 'transactions' ? 'aria-expanded=true' : '' }}>
                        <i class="tim-icons icon-bank"></i>
                        <span class="nav-link-text">Transactions</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ $section == 'transactions' ? 'show' : '' }}" id="transactions">
                        <ul class="nav pl-4">
                            <li @if ($pageSlug == 'tstats') class="active " @endif>
                                <a href="{{ route('transactions.stats')  }}">
                                    <i class="tim-icons icon-chart-pie-36"></i>
                                    <p>Statistics</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'transactions') class="active " @endif>
                                <a href="{{ route('transactions.index')  }}">
                                    <i class="tim-icons icon-bullet-list-67"></i>
                                    <p>All</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'sales') class="active " @endif>
                                <a href="{{ route('sales.index')  }}">
                                    <i class="tim-icons icon-bag-16"></i>
                                    <p>Sales</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'expenses') class="active " @endif>
                                <a href="{{ route('transactions.type', ['type' => 'expense'])  }}">
                                    <i class="tim-icons icon-coins"></i>
                                    <p>Expenses</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'incomes') class="active " @endif>
                                <a href="{{ route('transactions.type', ['type' => 'income'])  }}">
                                    <i class="tim-icons icon-credit-card"></i>
                                    <p>Income</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'transfers') class="active " @endif>
                                <a href="{{ route('transfer.index')  }}">
                                    <i class="tim-icons icon-send"></i>
                                    <p>Transfers</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'payments') class="active " @endif>
                                <a href="{{ route('transactions.type', ['type' => 'payment'])  }}">
                                    <i class="tim-icons icon-money-coins"></i>
                                    <p>Payments</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse"
                       href="#inventory" {{ $section == 'inventory' ? 'aria-expanded=true' : '' }}>
                        <i class="tim-icons icon-app"></i>
                        <span class="nav-link-text">Inventory</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ $section == 'inventory' ? 'show' : '' }}" id="inventory">
                        <ul class="nav pl-4">
                            <li @if ($pageSlug == 'istats') class="active " @endif>
                                <a href="{{ route('inventory.stats') }}">
                                    <i class="tim-icons icon-chart-pie-36"></i>
                                    <p>Statistics</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'products') class="active " @endif>
                                <a href="{{ route('products.index') }}">
                                    <i class="tim-icons icon-notes"></i>
                                    <p>Products</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'categories') class="active " @endif>
                                <a href="{{ route('categories.index') }}">
                                    <i class="tim-icons icon-tag"></i>
                                    <p>Categoríes</p>
                                </a>
                            </li>
                            <li @if ($pageSlug == 'receipts') class="active " @endif>
                                <a href="{{ route('receipts.index') }}">
                                    <i class="tim-icons icon-paper"></i>
                                    <p>Receipts</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li @if ($pageSlug == 'clients') class="active " @endif>
                    <a href="{{ route('clients.index') }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>Clients</p>
                    </a>
                </li>

                <li @if ($pageSlug == 'providers') class="active " @endif>
                    <a href="{{ route('providers.index') }}">
                        <i class="tim-icons icon-delivery-fast"></i>
                        <p>Providers</p>
                    </a>
                </li>

                <li @if ($pageSlug == 'methods') class="active " @endif>
                    <a href="{{ route('methods.index') }}">
                        <i class="tim-icons icon-wallet-43"></i>
                        <p>Methods and Accounts</p>
                    </a>
                </li>


                {{--<li>
                 <a data-toggle="collapse" href="#clients">
                     <i class="tim-icons icon-single-02" ></i>
                     <span class="nav-link-text">Clients</span>
                     <b class="caret mt-1"></b>
                 </a>

                 <div class="collapse" id="clients">
                     <ul class="nav pl-4">
                         <li @if ($pageSlug == 'clients-list')
                     class="active "@endif>
                             <a href="{{ route('clients.index')  }}">
                                 <i class="tim-icons icon-notes"></i>
                                 <p>Administrar Clients</p>
                             </a>
                         </li>
                         <li @if ($pageSlug == 'clients-create')
                     class="active " @endif>
                             <a href="{{ route('clients.create')  }}">
                                 <i class="tim-icons icon-simple-add"></i>
                                 <p>New Client</p>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>--}}

                @can(ApplicationPermissionConstants::viewUserManagementModule)
                    <li>
                        <a data-toggle="collapse" href="#users" {{ $section == 'users' ? 'aria-expanded=true' : '' }}>
                            <i class="tim-icons icon-badge"></i>
                            <span class="nav-link-text">Users</span>
                            <b class="caret mt-1"></b>
                        </a>

                        <div class="collapse {{ $section == 'users' ? 'aria-expanded=true' : '' }}" id="users">
                            <ul class="nav pl-4">
                                @can(ApplicationPermissionConstants::viewUserManagementModule)
                                    <li @if ($pageSlug == 'profile') class="active " @endif>
                                        <a href="{{ route('profile.edit')  }}">
                                            <i class="tim-icons icon-badge"></i>
                                            <p>My profile</p>
                                        </a>
                                    </li>
                                @endcan
                                @can(ApplicationPermissionConstants::viewUsers)
                                    <li @if ($pageSlug == 'users-list') class="active " @endif>
                                        <a href="{{ route('users.index')  }}">
                                            <i class="tim-icons icon-notes"></i>
                                            <p>Manage Users</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'roles-list') class="active " @endif>
                                        <a href="{{ route('roles.index')  }}">
                                            <i class="tim-icons icon-notes"></i>
                                            <p>Manage Roles</p>
                                        </a>
                                    </li>
                                @endcan
                                @can(ApplicationPermissionConstants::createUser)
                                    <li @if ($pageSlug == 'users-create') class="active " @endif>
                                        <a href="{{ route('users.create')  }}">
                                            <i class="tim-icons icon-simple-add"></i>
                                            <p>New user</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                <li>
                    <a data-toggle="collapse" href="#company" {{ $section == 'company' ? 'aria-expanded=true' : '' }}>
                        <i class="tim-icons icon-badge"></i>
                        <span class="nav-link-text">Company Management</span>
                        <b class="caret mt-1"></b>
                    </a>

                    <div class="collapse {{ $section == 'company' ? 'aria-expanded=true' : '' }}" id="users">
                        <ul class="nav pl-4">
                            <li @if ($pageSlug == 'company') class="active " @endif>
                                <a href="">
                                    <i class="tim-icons icon-badge"></i>
                                    <p>My Company</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
