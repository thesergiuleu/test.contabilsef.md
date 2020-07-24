<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $setting = $this->findSetting('site.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.site.title'),
                'value'        => 'Contabilsef, contabilitate, audit, impozite, taxe, contabil, fisc, cursuri, soft contabil, servicii, revista',
                'details'      => '',
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.site.description'),
                'value'        => __('voyager::seeders.settings.site.description'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 2,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.logo');
        if (!$setting->exists) {
            $this->uploadImage('logo.png');
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.site.logo'),
                'value'        => 'uploads/logo.png',
                'details'      => '',
                'type'         => 'image',
                'order'        => 3,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.address_footer_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Adresa subsol'),
                'value'        => 'Chişinău, str. Mitropolit Varlaam 65, of.313, MD-2001',
                'details'      => '',
                'type'         => 'text',
                'order'        => 4,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.email_footer_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Email subsol'),
                'value'        => 'office@contabilsef.md',
                'details'      => '',
                'type'         => 'text',
                'order'        => 5,
                'group'        => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.phone_footer_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Telefon subsol'),
                'value'        => '(+373 22) 22 49 37',
                'details'      => '',
                'type'         => 'text',
                'order'        => 6,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.fax_footer_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Fax subsol'),
                'value'        => '(+373 22) 22 49 37',
                'details'      => '',
                'type'         => 'text',
                'order'        => 6,
                'group'        => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.contabilsef');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Contabil sef'),
                'value'        => 'contabil șef',
                'details'      => '',
                'type'         => 'text',
                'order'        => 7,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.noutati');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Noutăți'),
                'value'        => 'noutăți',
                'details'      => '',
                'type'         => 'text',
                'order'        => 8,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.articole');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Articole'),
                'value'        => 'articole',
                'details'      => '',
                'type'         => 'text',
                'order'        => 9,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.instruire');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Instruire'),
                'value'        => 'instruire',
                'details'      => '',
                'type'         => 'text',
                'order'        => 10,
                'group'        => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.top');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Top cele mai citite'),
                'value'        => 'top cele mai citite',
                'details'      => '',
                'type'         => 'text',
                'order'        => 11,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.offers');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Oferte de serviciu'),
                'value'        => 'oferte de serviciu',
                'details'      => '',
                'type'         => 'text',
                'order'        => 12,
                'group'        => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.legislatia');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Legislatia'),
                'value'        => 'legislatia',
                'details'      => '',
                'type'         => 'text',
                'order'        => 12,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.twitter_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Twitter'),
                'value'        => config('app.url'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 13,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.facebook_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Facebook'),
                'value'        => 'https://facebook.com/contabilsef/',
                'details'      => '',
                'type'         => 'text',
                'order'        => 14,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.linkedin_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Linkedin'),
                'value'        => config('app.url'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 15,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.google_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Google'),
                'value'        => config('app.url'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 16,
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.rss_widget');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('Rss'),
                'value'        => config('app.url'),
                'details'      => '',
                'type'         => 'text',
                'order'        => 17,
                'group'        => 'Site',
            ])->save();
        }



        $setting = $this->findSetting('admin.bg_image');
        if (!$setting->exists) {
            $this->uploadImage('background.jpg');
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.background_image'),
                'value'        => 'uploads/background.jpg',
                'details'      => '',
                'type'         => 'image',
                'order'        => 5,
                'group'        => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.title'),
                'value'        => 'Contabil sef admin',
                'details'      => '',
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.description'),
                'value'        => 'Contabil sef admin pannel',
                'details'      => '',
                'type'         => 'text',
                'order'        => 2,
                'group'        => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.loader');
        if (!$setting->exists) {
            $this->uploadImage('loader.png');
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.loader'),
                'value'        => 'uploads/loader.png',
                'details'      => '',
                'type'         => 'image',
                'order'        => 3,
                'group'        => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.icon_image');
        if (!$setting->exists) {
            $this->uploadImage('icon.png');
            $setting->fill([
                'display_name' => __('voyager::seeders.settings.admin.icon_image'),
                'value'        => 'uploads/icon.png',
                'details'      => '',
                'type'         => 'image',
                'order'        => 4,
                'group'        => 'Admin',
            ])->save();
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }

    protected function uploadImage($name)
    {
        $newFile = new UploadedFile( public_path() . '/' . $name, $name, 'image/jpeg');
        $newFile->storePubliclyAs('uploads', $name, 'public');

    }
}
