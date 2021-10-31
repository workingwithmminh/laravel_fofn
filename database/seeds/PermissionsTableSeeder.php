<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arPermissions = [
            "1" => ["HomeController@index", "Trang chủ"],

            "2" => ["UsersController@index", "Tài khoản người dùng"],
            "3" => ["UsersController@show", "Tài khoản người dùng"],
            "4" => ["UsersController@store", "Tài khoản người dùng"],
            "5" => ["UsersController@update", "Tài khoản người dùng"],
            "6" => ["UsersController@destroy", "Tài khoản người dùng"],
            "7" => ["UsersController@active", "Tài khoản người dùng"],
            //Trường hợp cho phép người dùng sửa, thì cho phép sửa profile của người dùng đó
            "8" => ["UsersController@postProfile", "Tài khoản người dùng"],

            "9" => ["RolesController@index", "Quản lý Vai trò"],
            "10" => ["RolesController@show", "Quản lý Vai trò"],
            "11" => ["RolesController@store", "Quản lý Vai trò"],
            "12" => ["RolesController@update", "Quản lý Vai trò"],
            "13" => ["RolesController@destroy", "Quản lý Vai trò"],
            "14" => ["RolesController@active", "Quản lý Vai trò"],

            "15" => ["SettingController", "Cấu hình công ty"],

            //Quyền module News
            "16" => ["CategoryController@index", "Danh mục tin tức"],
            "17" => ["CategoryController@show", "Danh mục tin tức"],
            "18" => ["CategoryController@store", "Danh mục tin tức"],
            "19" => ["CategoryController@update", "Danh mục tin tức"],
            "20" => ["CategoryController@destroy", "Danh mục tin tức"],
            "21" => ["CategoryController@active", "Danh mục tin tức"],

            "22" => ["NewsController@index", "Tin tức"],
            "23" => ["NewsController@show", "Tin tức"],
            "24" => ["NewsController@store", "Tin tức"],
            "25" => ["NewsController@update", "Tin tức"],
            "26" => ["NewsController@destroy", "Tin tức"],
            "27" => ["NewsController@active", "Tin tức"],

            //Quyền module Theme
            "28" => ["SysMenuController@index", "Hệ thống menu"],
            "29" => ["SysMenuController@show", "Hệ thống menu"],
            "30" => ["SysMenuController@store", "Hệ thống menu"],
            "31" => ["SysMenuController@update", "Hệ thống menu"],
            "32" => ["SysMenuController@destroy", "Hệ thống menu"],
            "33" => ["SysMenuController@active", "Hệ thống menu"],

            "34" => ["PageController@index", "Trang"],
            "35" => ["PageController@show", "Trang"],
            "36" => ["PageController@store", "Trang"],
            "37" => ["PageController@update", "Trang"],
            "38" => ["PageController@destroy", "Trang"],
            "39" => ["PageController@active", "Trang"],

            "40" => ["SliderController@index", "Slider"],
            "41" => ["SliderController@show", "Slider"],
            "42" => ["SliderController@store", "Slider"],
            "43" => ["SliderController@update", "Slider"],
            "44" => ["SliderController@destroy", "Slider"],
            "45" => ["SliderController@active", "Slider"],

        ];

        //ADD PERMISSIONS - Thêm các quyền
        DB::table( 'permissions' )->delete();//empty permission
        $addPermissions = [];
        foreach ($arPermissions as $name => $label){
                $addPermissions[] = [
                    'id' => $name,
                    'name' => $label[0],
                    'label' => $label[1]
                ];
        }
        DB::table('permissions')->insert($addPermissions);

        //ADD ROLE - Them vai tro
//	    DB::table( 'roles' )->delete();//empty permission
        $datenow = date( 'Y-m-d H:i:s' );
        $role = [
            [ 'id' => 1, 'name' => 'company_admin', 'label' => 'Admin', 'created_at' => $datenow, 'updated_at' => $datenow ],
            [ 'id' => 2, 'name' => 'project_manager', 'label' => 'Project manager', 'created_at' => $datenow, 'updated_at' => $datenow ],
            [ 'id' => 3, 'name' => 'account_payable', 'label' => 'Account payable', 'created_at' => $datenow, 'updated_at' => $datenow ],
            [ 'id' => 4, 'name' => 'user', 'label' => 'User', 'created_at' => $datenow, 'updated_at' => $datenow ],
            [ 'id' => 5, 'name' => 'customer', 'label' => 'Customer', 'created_at' => $datenow, 'updated_at' => $datenow ],
        ];
        $addRoles = [];
        foreach ($role as $key => $label){
            if(\App\Role::where('id',$label['id'])->count() == 0 )
                $addRoles[] = [
                    'id' => $label['id'],
                    'name' => $label['name'],
                    'label' => $label['label'],
                    'created_at' => $datenow,
                    'updated_at' => $datenow
                ];
        }
        //KIỂM TRA VÀ THÊM CÁC VAI TRÒ TRUYỀN VÀO NẾU CÓ
        if (count($addRoles) > 0){
            DB::table('roles')->insert($addRoles);
        }

        //BỔ SUNG ID QUYỀN NẾU CÓ
        //Full quyền Admin công ty
        $persAdmin = \App\Permission::pluck('id');

        //Quyền quản lí task
        $persManager = [
            1,5,8
        ];

        //Quyền thanh toán
        $persPay = [
            1,5,8
        ];

        //Quyền cộng tác viên (vendor)
        $persVendor = [
            1,5,8
        ];

        //Quyền khách hàng
        $persCustomer = [
            1,5,8
        ];

        //Gán quyền vào Vai trò Admin
        $rolePerAdminCompany = \App\Role::findOrFail(1);
        $rolePerAdminCompany->permissions()->sync($persAdmin);

        //Gán quyền vào Vai trò Project Manager
        $rolePerCompanyEmployee = \App\Role::findOrFail(2);
        $rolePerCompanyEmployee->permissions()->sync($persManager);

        //Gán quyền vào Vai trò Account Pay
        $rolePerAgentAdmin = \App\Role::findOrFail(3);
        $rolePerAgentAdmin->permissions()->sync($persPay);

        //Gán quyền vào Vai trò Vendor
        $rolePerAgentEmployee = \App\Role::findOrFail(4);
        $rolePerAgentEmployee->permissions()->sync($persVendor);

        //Gán quyền vào Vai trò Customer
        $rolePerCustomer = \App\Role::findOrFail(5);
        $rolePerCustomer->permissions()->sync($persCustomer);

        //Set tài khoản ID=1 là Admin
        $roleAdmin = \App\User::findOrFail(1);
        $roleAdmin->roles()->sync([1]);
    }
}
