<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 54px; important
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #d8dbe0 !important;
    }

    .select2-selection__rendered {
        padding-bottom: 0 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 35px !important;
    }

</style>
<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/admins*") ? "c-show" : "" }} {{ request()->is("admin/merchants*") ? "c-show" : "" }} {{ request()->is("admin/partners*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    {{-- @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan --}}
                    @can('admin_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.admins.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/admins") || request()->is("admin/admins/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.admin.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('merchant_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.merchants.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/merchants") || request()->is("admin/merchants/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-tie c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.merchant.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('partner_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.partners.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/partners") || request()->is("admin/partners/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-friends c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.partner.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('transaction_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/deposits*") ? "c-show" : "" }} {{ request()->is("admin/balances*") ? "c-show" : "" }} {{ request()->is("admin/top-ups*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-money-bill-wave c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.transactionManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('top_up_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.deposits.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/deposits") || request()->is("admin/deposits/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.deposit.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('balance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.balances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/balances") || request()->is("admin/balances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-balance-scale c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.balance.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('deposit_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.top-ups.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/top-ups") || request()->is("admin/top-ups/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-donate c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.topUp.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('payout_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/payouts*") ? "c-show" : "" }} {{ request()->is("admin/payout-bulks*") ? "c-show" : "" }} {{ request()->is("admin/payout-banks*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.payoutManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('payout_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.payouts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payouts") || request()->is("admin/payouts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-clipboard-list c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.payout.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('payout_bulk_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.payout-bulks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payout-bulks") || request()->is("admin/payout-bulks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-invoice-dollar c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.payoutBulk.title') }}
                            </a>
                        </li>
                    @endcan
                    <!-- @can('payout_bank_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.payout-banks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/payout-banks") || request()->is("admin/payout-banks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.payoutBank.title') }}
                            </a>
                        </li>
                    @endcan -->
                </ul>
            </li>
        @endcan
        @can('currency_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/currencies*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw far fa-money-bill-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.currencyManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('currency_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.currencies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/currencies") || request()->is("admin/currencies/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-money-bill-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.currency.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('settlement_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/settlements*") ? "c-show" : "" }} {{ request()->is("admin/settlement-banks*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-tasks c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.settlementManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('settlement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.settlements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settlements") || request()->is("admin/settlements/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-clipboard-list c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.settlement.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('settlement_bank_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.settlement-banks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settlement-banks") || request()->is("admin/settlement-banks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.settlementBank.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('project_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/api-keys*") ? "c-show" : "" }} {{ request()->is("admin/gate-saving-accounts*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fab fa-hubspot c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.gateManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-link c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.project.title') }}
                            </a>
                        </li>
                    @endcan
                    <!-- @can('api_key_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.api-keys.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/api-keys") || request()->is("admin/api-keys/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-keycdn c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.apiKey.title') }}
                            </a>
                        </li>
                    @endcan -->
                    @can('project_saving_account_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.gate-saving-accounts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/gate-saving-accounts") || request()->is("admin/gate-saving-accounts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.gateSavingAccount.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('saving_account_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/saving-accounts*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.savingAccountManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('saving_account_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.saving-accounts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/saving-accounts") || request()->is("admin/saving-accounts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.savingAccount.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('security_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/whitelist-ip-addresses*") ? "c-show" : "" }} {{ request()->is("admin/whitelist-emails*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.securityManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('whitelist_ip_address_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.whitelist-ip-addresses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/whitelist-ip-addresses") || request()->is("admin/whitelist-ip-addresses/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-calendar-check c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.whitelistIpAddress.title') }}
                            </a>
                        </li>
                    @endcan
                    <!-- @can('whitelist_email_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.whitelist-emails.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/whitelist-emails") || request()->is("admin/whitelist-emails/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-calendar-check c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.whitelistEmail.title') }}
                            </a>
                        </li>
                    @endcan -->
                </ul>
            </li>
        @endcan
        @can('reporting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/reporting*") ? "c-show" : "" }} {{ request()->is("admin/reporting*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.reporting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('daily_statement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.reporting.daily_statement") }}" class="c-sidebar-nav-link {{ request()->is("admin/reporting") || request()->is("admin/reporting/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.dailyStatement.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('deposit_daily_adjustment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.reporting.deposit_daily_adjustment") }}" class="c-sidebar-nav-link {{ request()->is("admin/reporting") || request()->is("admin/reporting/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.deposit_daily_adjustment.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
