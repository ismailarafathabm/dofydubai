<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li id="dashboard_menu">
                    <a href="#!/"><img src="assets/img/icons/dashboard.svg"
                            alt="img" /><span>
                            Dashboard</span>
                    </a>
                </li>
                <?php
                $haveaccessmenudevicesettings = !isset($xaccess['devicesettings']['fullmenu']) ? false : $xaccess['devicesettings']['fullmenu'];
                if ($haveaccessmenudevicesettings) {
                ?>
                    <li class="submenu">
                        <a href="javascript:void(0);" id="product_menu">
                            <img src="assets/img/icons/product.svg" alt="img" />
                            <span>
                                Devices settings
                            </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php
                            $haveaccessmenumodels = !isset($xaccess['devicesettings']['models']['viewaccess']) ? false : $xaccess['devicesettings']['models']['viewaccess'];
                            if ($haveaccessmenumodels) {
                            ?>
                                <li>
                                    <a href="#!/product-model" id="model_submenu">
                                        <span>Models</span>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            $haveaccessmenuconidtion = !isset($xaccess['devicesettings']['conditions']['viewaccess']) ? false : $xaccess['devicesettings']['conditions']['viewaccess'];
                            if ($haveaccessmenuconidtion) {
                            ?>
                                <li>
                                    <a href="#!/product-conditions" id="condition_submenu">
                                        <span>Conditions</span>
                                    </a>
                                </li>
                            <?php
                            }
                            $haveaccessmenukitstatus = !isset($xaccess['devicesettings']['kitstatus']['viewaccess']) ? false : $xaccess['devicesettings']['kitstatus']['viewaccess'];
                            if ($haveaccessmenukitstatus) {
                            ?>
                                <li>
                                    <a href="#!/kits-status" id="kitstatus_submenu">
                                        <span>Kits Status</span>
                                    </a>
                                </li>
                            <?php
                            }
                            $haveaccessmenuchargertype = !isset($xaccess['devicesettings']['chargertype']['viewaccess']) ? false : $xaccess['devicesettings']['chargertype']['viewaccess'];
                            if ($haveaccessmenuchargertype) {
                            ?>
                                <li>
                                    <a href="#!/charger-types" id="chargertype_submenu">
                                        <span>Charger Types</span>
                                    </a>
                                </li>
                            <?php
                            }

                            $haveaccessmenuwarranty = !isset($xaccess['devicesettings']['warranty']['viewaccess']) ? false : $xaccess['devicesettings']['warranty']['viewaccess'];
                            if ($haveaccessmenuwarranty) {
                            ?>
                                <li>
                                    <a href="#!/warrantys" id="warranty_submenu">
                                        <span>Warrantys</span>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>




                        </ul>
                    </li>
                <?php
                }
                $haveAccessMenuStockentry = !isset($xaccess['stockentrys']['fullmenu']) ? false : $xaccess['stockentrys']['fullmenu'];

                if ($haveAccessMenuStockentry) {
                ?>
                    <li class="submenu">
                        <a href="javascript:void(0);" id="stockentry_menu">
                            <img src="assets/img/icons/purchase1.svg" alt="img" />
                            <span>
                                Stock Entry
                            </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php
                            $haveAccessSubMenuNewStockEntry = !isset($xaccess['stockentrys']['new']) ? false : $xaccess['stockentrys']['new'];
                            if ($haveAccessSubMenuNewStockEntry) {
                            ?>
                                <li>
                                    <a href="#!/stockentry-new" id="newstockentry_submenu">
                                        <span>New</span>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                    </li>
                <?php
                }
                ?>



                <?php

                if ($sessionuser === "superadmin") {
                ?>
                    <li id="user_menu">
                        <a href="#!users-list"><img src="assets/img/icons/users1.svg" alt="img" /><span>
                                Users</span>
                        </a>
                    </li>
                <?php
                }
                $haveAccessMenuShopsView = !isset($xaccess['shops']['fullmenu']) ? false : $xaccess['shops']['fullmenu'];
                if ($haveAccessMenuShopsView) {
                ?>
                    <li id="shop_menu">
                        <a href="#!shop-list"><img src="assets/img/icons/places.svg" alt="img" /><span>
                                Shops</span>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li id="changepassword_menu">
                    <a href="#!changepassword"><img src="assets/img/icons/settings.svg" alt="img" /><span>
                            Change Password</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>