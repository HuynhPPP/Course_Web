<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SettingController extends Controller
{
    public function SmtpSetting()
    {
        $smtp = SmtpSetting::find(1);

        return view('admin.backend.setting.smtp_update', compact('smtp'));
    }

    public function SmtpUpdate(Request $request)
    {
        $smtp_id = $request->id;

        SmtpSetting::find($smtp_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);

        $notification = array(
            'message' => 'Smtp Setting Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function SiteSetting()
    {
        $site = SiteSetting::find(1);

        return view('admin.backend.site.site_update', compact('site'));
    }


    public function UpdateSite(Request $request)
    {
        $site_id = $request->id;

        if ($request->file('logo')) {
            $image = $request->file('logo');

            // Tạo tên file duy nhất
            $name_generate = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_path = public_path('upload/logo/');
            $save_url = 'upload/logo/' . $name_generate;

            $manager = new ImageManager(Driver::class);

            // Xử lý ảnh
            $manager->read($image->getPathname())
                ->resize(140, 41)
                ->save($save_path . $name_generate);

            SiteSetting::find($site_id)->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'X' => $request->X,
                'copyright' => $request->copyright,
                'logo' => $save_url,
            ]);

            $notification = array(
                'message' => 'Site Setting updated with logo successfully',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

        } else {
            SiteSetting::find($site_id)->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'X' => $request->X,
                'copyright' => $request->copyright,
            ]);

            $notification = array(
                'message' => 'Site Setting updated without logo successfully',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }
}
