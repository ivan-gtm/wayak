<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);

class CanvaController extends Controller
{
    public function index(){
        
        $thumb_urls = self::getThumbUrls();

        foreach ($thumb_urls as $img_url) {
            // $img_url = 'https://template.canva.com/EADajvtdmjY/1/0/400w-9vWhnLEersE.jpg';
            $template_id = str_replace( 'https://template.canva.com/', null , $img_url );
            $template_id = substr( $template_id, 0, strpos( $template_id,  '/' ) );
            
            // echo $img_url;
            // echo "<br>";
            // echo $template_id;
            // exit;

            $img_url_info = pathinfo($img_url);
            $full_file_path = public_path( 'canva/design/template/'.$template_id.'/assets/'.$img_url_info['basename'] );
            $path_info = pathinfo($full_file_path);
            $local_img_path = $path_info['dirname'];

            if( file_exists( $full_file_path )  == false ){
                // echo $full_file_path;
                // exit;
    
                self::downloadImage($full_file_path, $img_url);
                // exit;
            }
            
        }
    }

    function getThumbUrls(){
        $thumb_urls = [
            'https://template.canva.com/EADaiGiXFMo/3/0/224w-5ieZwQOeIso.mp4',
            'https://template.canva.com/EADaiGiXFMo/3/0/224w-5ieZwQOeIso.mp4',
            'https://template.canva.com/EADaiGiXFMo/3/0/224w-5ieZwQOeIso.mp4',
            'https://template.canva.com/EADaiGiXFMo/3/0/224w-5ieZwQOeIso.mp4',
            'https://template.canva.com/EADaiGiXFMo/3/0/224w-5ieZwQOeIso.mp4',
            'https://template.canva.com/EADaiGiXFMo/3/0/224w-5ieZwQOeIso.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAEMiqvSjj8/1/0/224w-TuaGO5fkBsY.mp4',
            'https://template.canva.com/EAD42S9DFkg/2/0/225w-lk9IivyhFWA.jpg',
            'https://template.canva.com/EAEOVMLvLuE/1/0/225w-U4Wm6z8apoE.jpg',
            'https://template.canva.com/EAELNqIxJPQ/1/0/225w-TANAsFyfBhQ.jpg',
            'https://template.canva.com/EAEMio4fGog/1/0/225w-3UXWPnfnGfU.jpg',
            'https://template.canva.com/EAEMirwxb0k/1/0/225w-KZuyGWhrlKI.jpg',
            'https://template.canva.com/EAEMigmHHic/1/0/225w-Ltf32T1lK-c.jpg',
            'https://template.canva.com/EAEMi4Si-aQ/1/0/225w--0CBzwCarYI.jpg',
            'https://template.canva.com/EADaiGdYuX4/3/0/225w-Q8UsJaCOFlY.jpg',
            'https://template.canva.com/EAD22ve41Q8/2/0/225w-57M5qnOzR7A.jpg',
            'https://template.canva.com/EAEDP1V5XUk/1/0/225w-mtpp9kpxPZs.jpg',
            'https://template.canva.com/EAEGKHKiT54/1/0/225w-7RJRU5Ju4vw.jpg',
            'https://template.canva.com/EADan3f3Mzg/2/0/225w-WoxMnz1pawg.jpg',
            'https://template.canva.com/EAEMiztc3K8/1/0/225w-XVLNhJaVeDI.jpg',
            'https://template.canva.com/EAEOeqz2fPA/1/0/225w-50zShK_aejI.jpg',
            'https://template.canva.com/EAEDI2dm1n4/1/0/225w-aZhTtRLclp8.jpg',
            'https://template.canva.com/EAEFGzswCOU/1/0/225w-vl14vn9bNyI.jpg',
            'https://template.canva.com/EAEL4t13EEc/1/0/225w-L70A1-703ss.jpg',
            'https://template.canva.com/EADwHmo8YGg/1/0/225w-iAtMERhsEPk.jpg',
            'https://template.canva.com/EADyQeOXCCE/1/0/225w-MQgUzkgMA0Q.jpg',
            'https://template.canva.com/EAEGKKE5TnA/3/0/225w-zWKwXBYbsqI.jpg',
            'https://template.canva.com/EAEMi6ujTIc/1/0/225w-_JJ-FYGlYgA.jpg',
            'https://template.canva.com/EAEEGSwv3NA/1/0/225w-zazJz6Bl3r8.jpg',
            'https://template.canva.com/EAED4rjyiBw/2/0/225w-TLbthneiiCw.jpg',
            'https://template.canva.com/EAEL5f1ti1g/1/0/225w-aUdy2K9ecGg.jpg',
            'https://template.canva.com/EAEN1o1zJDE/1/0/225w-pyG0DOMqsDw.jpg',
            'https://template.canva.com/EADaiDIJdXM/2/0/225w--ljb-miaCa0.jpg',
            'https://template.canva.com/EADaoBHsVB0/2/0/225w-73IaWieoycM.jpg',
            'https://template.canva.com/EADgdpAdLrk/1/0/225w-MRZexphbv6c.jpg',
            'https://template.canva.com/EADaok1WJHQ/6/0/225w-z6h5uucPPBw.jpg',
            'https://template.canva.com/EAEEdjYwRtI/1/0/225w-UBhg4PfPL20.jpg',
            'https://template.canva.com/EADyWz3ZaP4/1/0/225w-UTlGSeGRFa0.jpg',
            'https://template.canva.com/EADy76pFXZ0/2/0/225w-lnva_h3MQwU.jpg',
            'https://template.canva.com/EAD8HqfIXUY/2/0/225w-rh52eFGwOH8.jpg',
            'https://template.canva.com/EAEL5Ytazoo/1/0/225w-UBLrxdtbOEw.jpg',
            'https://template.canva.com/EAEEGbJ4vvg/1/0/225w-TpO3-Hh1Gts.jpg',
            'https://template.canva.com/EAD3Z3XJXac/2/0/225w-7uO355FtFj0.jpg',
            'https://template.canva.com/EADankSVncs/4/0/225w-qxKBIL2ptzA.jpg',
            'https://template.canva.com/EADao6yfBEA/4/0/225w-tY1hsiFPz5E.jpg',
            'https://template.canva.com/EAEGKRN62-Q/1/0/225w-lJWZVoLaHL4.jpg',
            'https://template.canva.com/EADyKXIqH6o/2/0/225w-ARhv7LDqcVc.jpg',
            'https://template.canva.com/EAELM7YOyhI/1/0/225w-O96gtBHvjL4.jpg',
            'https://template.canva.com/EADyQRmysUc/1/0/225w-LG_SM9lyvrE.jpg',
            'https://template.canva.com/EAELnont2jM/1/0/225w-XWOnMjqXc0g.jpg',
            'https://template.canva.com/EADgdgjNFVU/2/0/225w-jBs-bEBXntk.jpg',
            'https://template.canva.com/EADblK6yqsA/1/0/225w-dpbhLAKObE8.jpg',
            'https://template.canva.com/EAD5fiY0gBM/3/0/225w-_Z8F--cZXVk.jpg',
            'https://template.canva.com/EAD3aCmai7M/1/0/225w-ziofyAQXZOI.jpg',
            'https://template.canva.com/EADaonUByA0/1/0/225w-P99hvUOtf6A.jpg',
            'https://template.canva.com/EADyKFFSpGM/2/0/225w-LdZoDzhHQ3A.jpg',
            'https://template.canva.com/EAD5fujUUmA/3/0/225w--P3ZcEL3RWM.jpg',
            'https://template.canva.com/EAD9mRbPcGo/1/0/225w-eEn3OntoA1U.jpg',
            'https://template.canva.com/EAD9m0cU_5A/1/0/225w-C1689Bm9LkY.jpg',
            'https://template.canva.com/EADapL_mZfs/7/0/225w-nYBegw0mr-Q.jpg',
            'https://template.canva.com/EADao8ZVMIo/2/0/225w-E6aZRA6uZsU.jpg',
            'https://template.canva.com/EADaovYObrs/2/0/225w-8JGOW8wP6SI.jpg',
            'https://template.canva.com/EAEAn0MKSH4/1/0/225w-CqtRgqIfFfY.jpg',
            'https://template.canva.com/EAEIHhifLJo/1/0/225w-1GS3YXOh2pk.jpg',
            'https://template.canva.com/EAEAngtt5-0/1/0/225w-G4rZyr4bTWs.jpg',
            'https://template.canva.com/EADaog5aee8/1/0/225w-C3UVPmW47H0.jpg',
            'https://template.canva.com/EADyKDDGfUE/2/0/225w-qvfjR_Bhz2o.jpg',
            'https://template.canva.com/EAEEeY_S678/1/0/225w-PysAZMuKTfs.jpg',
            'https://template.canva.com/EADkZgCwnLI/1/0/225w-njv21xmJV88.jpg',
            'https://template.canva.com/EADangQk8hw/4/0/225w-gZR7epH-hbU.jpg',
            'https://template.canva.com/EAEKAN9ryIE/1/0/225w-6lm-WG10WV4.jpg',
            'https://template.canva.com/EADyV3YcYxo/1/0/225w-Wm8z_gzuAjA.jpg',
            'https://template.canva.com/EAEAn42-uHc/1/0/225w-tMbdXRm1djE.jpg',
            'https://template.canva.com/EAEAnrHv75A/1/0/225w-0QySo_PJCHI.jpg',
            'https://template.canva.com/EAEAntlrYos/1/0/225w-e5-k-KRPOy0.jpg',
            'https://template.canva.com/EAD3hg7anXo/1/0/225w-WaLhMrECEHs.jpg',
            'https://template.canva.com/EAEMixoGa6Y/1/0/225w-DFRqmm_XLOE.jpg',
            'https://template.canva.com/EAD1dd2i9CM/1/0/225w-KGwnQ4IqlnE.jpg',
            'https://template.canva.com/EAD5fpL-3MI/2/0/225w-GtbYuz7e_nM.jpg',
            'https://template.canva.com/EAEGJyZXoWg/1/0/225w-tAqylTNB-L0.jpg',
            'https://template.canva.com/EAD5fkvsmkE/1/0/225w-ia-n2TEh_UU.jpg',
            'https://template.canva.com/EAEL4o_7l3g/3/0/225w-ws7mUAa1qtU.jpg',
            'https://template.canva.com/EADwGlcRgaY/1/0/225w-4H9ow1NO6lw.jpg',
            'https://template.canva.com/EADgdqoQYTI/2/0/225w-w5KO8Ea157M.jpg',
            'https://template.canva.com/EADan88aKcM/1/0/225w-o2PEY2UXeNM.jpg',
            'https://template.canva.com/EADwHt04jn0/1/0/225w-omfVdMZlBNM.jpg',
            'https://template.canva.com/EADgdWaBfm0/2/0/225w-byW7nyYx_I0.jpg',
            'https://template.canva.com/EAD5f3bju-c/2/0/225w-u9fTbH1eQXU.jpg',
            'https://template.canva.com/EADaoL4VMPo/2/0/225w-mL5s_DhWEZ4.jpg',
            'https://template.canva.com/EADyQdgYVI4/1/0/225w-qJTXSNQKTYY.jpg',
            'https://template.canva.com/EAEFGgl6AfY/1/0/225w-PNukJssJ-aw.jpg',
            'https://template.canva.com/EAD8wHim4Yc/2/0/225w-zW3bx4f3sCo.jpg',
            'https://template.canva.com/EADjYehRO2M/1/0/225w-2-NxdVqSdkM.jpg',
            'https://template.canva.com/EAEGJ7c-s0s/1/0/225w-XUckrgrWKXs.jpg',
            'https://template.canva.com/EAEL7H-YRwY/1/0/225w-DhzPInyFO3g.jpg',
            'https://template.canva.com/EADgdVFh5KI/3/0/225w-6C4W_Fhu8r0.jpg',
            'https://template.canva.com/EAD3hqrCBAo/1/0/225w-w31L52zzBbc.jpg',
            'https://template.canva.com/EAEIIA7bSdc/1/0/225w-TN1elvUnIK4.jpg',
            'https://template.canva.com/EADan3rRZuM/3/0/225w-68MoPrCc2gg.jpg',
            'https://template.canva.com/EAEHvuVizAc/1/0/225w-BTCsZU97yVM.jpg',
            'https://template.canva.com/EAD5fqkj7K4/3/0/225w-ovDQcQ8tQkI.jpg',
            'https://template.canva.com/EAD3aKA9-L8/1/0/225w-L8NWzgQFfSo.jpg',
            'https://template.canva.com/EADan6QuDFY/1/0/225w-oq42KrMBo0I.jpg',
            'https://template.canva.com/EAD9m0m9hrs/1/0/225w-VDbL_SR2xlA.jpg',
            'https://template.canva.com/EAD22nGTpto/1/0/225w-UvkYw7_rZro.jpg',
            'https://template.canva.com/EADgdw9nbjk/1/0/225w-XpqNsvh-Xj4.jpg',
            'https://template.canva.com/EAD3a4GXU9c/2/0/225w-ca76I7xL_Ro.jpg',
            'https://template.canva.com/EADyXOmMw5A/1/0/225w-1JUbdJQ6TF0.jpg',
            'https://template.canva.com/EADgW3ZcirI/3/0/225w-ZRRq7o7Fz9k.jpg',
            'https://template.canva.com/EADjEbuTgHs/1/0/225w-R1S8HNVRp1E.jpg',
            'https://template.canva.com/EAD_fWIKbyM/1/0/225w-DB8XXOPcSfU.jpg',
            'https://template.canva.com/EADaot3OIj4/1/0/225w-F_YNq6yZ9GA.jpg',
            'https://template.canva.com/EADaosopUOg/3/0/225w-mF9otLnrL-o.jpg',
            'https://template.canva.com/EADyR0MRBLE/1/0/225w-6fFhXiJQrEw.jpg',
            'https://template.canva.com/EAD5Zhl_e8k/1/0/225w-GE5S0ZbrJ5Q.jpg',
            'https://template.canva.com/EADaoRIFXTk/4/0/225w-v8aZUsb-AK0.jpg',
            'https://template.canva.com/EAEAnkIBaIg/1/0/225w-i5k2pKOmAKc.jpg',
            'https://template.canva.com/EAEKXtdpHKg/2/0/225w-yEi-1KDuiIc.jpg',
            'https://template.canva.com/EAEGKOABt6Q/1/0/225w-6kc9ZDBqmSY.jpg',
            'https://template.canva.com/EAD3aP3bCXY/1/0/225w-rh7yqexhZl8.jpg',
            'https://template.canva.com/EADakLDqv7E/5/0/225w-E7oQaijB3zg.jpg',
            'https://template.canva.com/EAEL3rijlDE/1/0/225w-Ngahh3UnbNE.jpg',
            'https://template.canva.com/EAEF8Ll2MPI/2/0/225w-V-9zpgDloak.jpg',
            'https://template.canva.com/EADhqJ47Lac/1/0/225w-O_dWexrrWf0.jpg',
            'https://template.canva.com/EADblBv4wvM/1/0/225w-UMGGDbrgvEw.jpg',
            'https://template.canva.com/EADajxFsHnQ/1/0/225w-dRYd_cxi8Oo.jpg',
            'https://template.canva.com/EAD5fcEiKFo/3/0/225w-MTOH5IHG4K0.jpg',
            'https://template.canva.com/EAD9mcFWcRA/1/0/225w-Lr5awa8ntMA.jpg',
            'https://template.canva.com/EADwH-yGhPk/1/0/225w-2d58he9UuA0.jpg',
            'https://template.canva.com/EAD1c_brBXU/2/0/225w-wymL7D1Hqyc.jpg',
            'https://template.canva.com/EAD3a-TtSNg/1/0/225w-YbTMlHKMDzc.jpg',
            'https://template.canva.com/EAEAnaR-aU0/1/0/225w-cEghcXtndfI.jpg',
            'https://template.canva.com/EAEJyluPXuY/1/0/225w-SVZYXXHwmZk.jpg',
            'https://template.canva.com/EADt2zKBfaQ/2/0/225w-60p8QApofDo.jpg',
            'https://template.canva.com/EADgdjtFXBE/1/0/225w-NA37q6B5aXk.jpg',
            'https://template.canva.com/EADibt0qmE8/1/0/225w-oji2rFR-vuk.jpg',
            'https://template.canva.com/EAD3tn5j4do/1/0/225w-Ui-5DIENy6s.jpg',
            'https://template.canva.com/EADjRttGWao/1/0/225w-80ykYmKyNxA.jpg',
            'https://template.canva.com/EAD9mUM1rMo/1/0/225w-SJ06aqIBp1k.jpg',
            'https://template.canva.com/EAD9matrLM4/1/0/225w-vhrZuFO8bv0.jpg',
            'https://template.canva.com/EAEHKxzRABY/2/0/225w-Hxik6h4G0O8.jpg',
            'https://template.canva.com/EAD22nQPraU/1/0/225w-RPKPbe0SL9o.jpg',
            'https://template.canva.com/EADiaUAdUM4/1/0/225w-wn9gNOwp8Yo.jpg',
            'https://template.canva.com/EAD-0hs2Wd0/1/0/225w-MbTROHy5cow.jpg',
            'https://template.canva.com/EADj1ib1n4g/1/0/225w-hk56ctn3y9A.jpg',
            'https://template.canva.com/EAEAn7XaqCg/1/0/225w-pxIe5wvb97Q.jpg',
            'https://template.canva.com/EADaiKfmDfw/3/0/225w-djIZ7hQiM6A.jpg',
            'https://template.canva.com/EAD2TW4WVRk/1/0/225w-OANfTCiGNF0.jpg',
            'https://template.canva.com/EADjYZluIrQ/1/0/225w-aar-vVQIcHo.jpg',
            'https://template.canva.com/EAD_lt0tN-c/1/0/225w-V6g3kGEL-ck.jpg',
            'https://template.canva.com/EAELM-4sp1Q/1/0/225w-sqFr-6Xa0Yc.jpg',
            'https://template.canva.com/EADao6e3lsE/1/0/225w-eVkiGqyO2Gs.jpg',
            'https://template.canva.com/EAD8rAttJBk/1/0/225w-oObUQHsV4_o.jpg',
            'https://template.canva.com/EAD1dj4ckM4/1/0/225w-F7-V0ND30wI.jpg',
            'https://template.canva.com/EAD2YNiYsjg/2/0/225w-TCFvG0mhfdk.jpg',
            'https://template.canva.com/EAEF8rPVWRQ/1/0/225w-fXxF2gO3AiY.jpg',
            'https://template.canva.com/EADjYRIScxc/1/0/225w-UGv4ljjb_GQ.jpg',
            'https://template.canva.com/EAEF9qYKntg/1/0/225w-OOxmyP8PcnI.jpg',
            'https://template.canva.com/EADaobq3p-A/3/0/225w-8NyVGoDWZ-Q.jpg',
            'https://template.canva.com/EAELATixkms/1/0/225w-_Dchn9cmMSE.jpg',
            'https://template.canva.com/EAEAn0G9WrY/1/0/225w-5nBRN-dRwgg.jpg',
            'https://template.canva.com/EAD5ZkGHc6M/1/0/225w-XjQem18l2fY.jpg',
            'https://template.canva.com/EAD1c5Sd2KE/1/0/225w-47zZJ02-HEQ.jpg',
            'https://template.canva.com/EAELMwdFh_0/1/0/225w-w3SPjFKGRHw.jpg',
            'https://template.canva.com/EADaoqWmNOM/1/0/225w-e59vzXSZxoU.jpg',
            'https://template.canva.com/EADwTzasLPM/1/0/225w-AaD5X4zkNoY.jpg',
            'https://template.canva.com/EAELv1tnQhM/2/0/225w-nWW7w4dwHG8.jpg',
            'https://template.canva.com/EAD3hcYS1Kc/1/0/225w-lgZQ4cQ9g0s.jpg',
            'https://template.canva.com/EAELnt6Iutw/1/0/225w-VC2JF9d3Kjk.jpg',
            'https://template.canva.com/EADis2k3joE/1/0/225w-8ikdN78Q2kg.jpg',
            'https://template.canva.com/EADwT4rRFP8/1/0/225w-Y-QALv8M8-c.jpg',
            'https://template.canva.com/EAEMi0UzyHg/1/0/225w-48WsEvmXizQ.jpg',
            'https://template.canva.com/EAEAnr8UYa8/1/0/225w-qk-dQUUZnNI.jpg',
            'https://template.canva.com/EADt24YVMpw/2/0/225w-EC2e3pDfSOo.jpg',
            'https://template.canva.com/EADyR_F9PK0/1/0/225w-7TfGP6xaaGk.jpg',
            'https://template.canva.com/EADaoliRRSs/7/0/225w-jxY2lDQ5mIo.jpg',
            'https://template.canva.com/EADyKMVnQP0/2/0/225w-aOTmgrWH7Ao.jpg',
            'https://template.canva.com/EAD5f-FEpD0/1/0/225w-ANWh5C-2v9g.jpg',
            'https://template.canva.com/EAD3Vpg0sjU/2/0/225w-czlyiDdsbYQ.jpg',
            'https://template.canva.com/EAEFHeQTaVA/1/0/225w-o0lJ3iMT9nE.jpg',
            'https://template.canva.com/EADyKflEIyM/3/0/225w-kwZJ3AG1Vws.jpg',
            'https://template.canva.com/EAD-0pXyfq8/1/0/225w-RwrQwAS2uhs.jpg',
            'https://template.canva.com/EADuaPrFLw4/1/0/225w-2q5exfxFdaI.jpg',
            'https://template.canva.com/EAD3adv_MCs/1/0/225w-0gpGhR66qbQ.jpg',
            'https://template.canva.com/EADi_YRJEPo/1/0/225w-MfG-izjYvkY.jpg',
            'https://template.canva.com/EAD9_2ZQjT8/2/0/225w-Lewo45j1XZM.jpg',
            'https://template.canva.com/EADaoxRBbVU/2/0/225w-BzR8QjS8ayM.jpg',
            'https://template.canva.com/EAEEebtfg54/1/0/225w-nZaVxdHhfaQ.jpg',
            'https://template.canva.com/EADyFjV3qrc/1/0/225w-pCzZ8y4EvcI.jpg',
            'https://template.canva.com/EAD1dofUc-E/1/0/225w-OSjFb26v3_o.jpg',
            'https://template.canva.com/EAD5fYu-Yok/2/0/225w-vfJZ52Rs_1Y.jpg',
            'https://template.canva.com/EADanr2MOlM/1/0/225w-qJkGaWH8p-s.jpg',
            'https://template.canva.com/EAD5fVXrO10/2/0/225w-REwiy8Ygs-A.jpg',
            'https://template.canva.com/EADt2SEeAxA/2/0/225w-NjKaC8p3k0A.jpg',
            'https://template.canva.com/EAEGKXAWP8g/1/0/225w-pVK5sYij0io.jpg',
            'https://template.canva.com/EAEGKaWV03M/1/0/225w-3RxisNFrzKs.jpg',
            'https://template.canva.com/EADaofC2l1I/1/0/225w-bIFrhX0Rih0.jpg',
            'https://template.canva.com/EADy796efT0/4/0/225w-nLl81sJxhHM.jpg',
            'https://template.canva.com/EADiaNJoDQg/1/0/225w-JU20d-x8NVA.jpg',
            'https://template.canva.com/EADaofUcDPI/3/0/225w-rRsic1z-W90.jpg',
            'https://template.canva.com/EADb2qUtzl8/2/0/225w-9dbONyRQvrE.jpg',
            'https://template.canva.com/EADao1ZGZa8/1/0/225w-Al3_pzyBpbw.jpg',
            'https://template.canva.com/EAEOejfj4jQ/2/0/225w-FR4z2QNAf2Y.jpg',
            'https://template.canva.com/EADyXGwGBsw/1/0/225w-M8c0S3j6fI0.jpg',
            'https://template.canva.com/EAELM62yKMo/1/0/225w-vGmU0AJU44s.jpg',
            'https://template.canva.com/EADjFWnMjX8/1/0/225w-nk6SYX-0VqY.jpg',
            'https://template.canva.com/EAD9mpaE3oU/1/0/225w-0cSqntYCzAU.jpg',
            'https://template.canva.com/EADj8NNpNX0/1/0/225w-UGyFT1HJiLA.jpg',
            'https://template.canva.com/EADaoPffwCE/2/0/225w-wgvSPrwo0B8.jpg',
            'https://template.canva.com/EADjRlrsBKY/1/0/225w-qzmVWIQySW0.jpg',
            'https://template.canva.com/EAD-0sIBqpE/1/0/225w-pdAdc1oeCTA.jpg',
            'https://template.canva.com/EAEMwaRu7xg/1/0/225w-OzFz-ysyaR8.jpg',
            'https://template.canva.com/EADt2WLwaxg/2/0/225w-Mtfgw0sEFIc.jpg',
            'https://template.canva.com/EAD2SoyO7WE/1/0/225w-Fdx9JuYut3c.jpg',
            'https://template.canva.com/EADvLlRwWlM/1/0/225w-m4RsRpVdm0o.jpg',
            'https://template.canva.com/EAEAnUNxih4/1/0/225w-NkFe6g40pqA.jpg',
            'https://template.canva.com/EAEEGu4dYOU/1/0/225w-Q7KP9dSWNuY.jpg',
            'https://template.canva.com/EAEAseilEZs/2/0/225w-1xcWSF3LGTg.jpg',
            'https://template.canva.com/EADaoV4s8RU/2/0/225w-fOBajsudb7k.jpg',
            'https://template.canva.com/EADaolaQjGA/1/0/225w-yRX2JwMhUZM.jpg',
            'https://template.canva.com/EAEGKaR8xj4/1/0/225w-gkwWjG-5I9k.jpg',
            'https://template.canva.com/EAD5fdXcH6g/3/0/225w-EdrYvDNQ_BI.jpg',
            'https://template.canva.com/EAD3hkVytLw/1/0/225w-gSHIgVXw1PA.jpg',
            'https://template.canva.com/EADuaBqzZwE/2/0/225w-A8-ZeygYeww.jpg',
            'https://template.canva.com/EADgd5nRp14/1/0/225w-6k-AsTYvBNU.jpg',
            'https://template.canva.com/EADajrDQI3Q/1/0/225w-pYKJG6_OPdI.jpg',
            'https://template.canva.com/EAD29se4SuA/2/0/225w-BVRFlAETaig.jpg',
            'https://template.canva.com/EADgcCZshL8/1/0/225w-kLsegf8oOE4.jpg',
            'https://template.canva.com/EADgdlp8IhM/2/0/225w-3x338JKxB6Q.jpg',
            'https://template.canva.com/EADj19CztNA/1/0/225w-5r4H6cOFXCM.jpg',
            'https://template.canva.com/EAD3abe8Z5w/1/0/225w-PuIaot1aCZ8.jpg',
            'https://template.canva.com/EAD3hvk50RM/1/0/225w-FZkscUKtnJc.jpg',
            'https://template.canva.com/EAEL4jWRfVY/1/0/225w-RXkxkZ5kQqk.jpg',
            'https://template.canva.com/EADtqoXxtfM/2/0/225w-mCRktjeHz64.jpg',
            'https://template.canva.com/EADapJ7JTCM/4/0/225w-YQ9ofABwlwQ.jpg',
            'https://template.canva.com/EADaoqC-gB0/1/0/225w-G8nVJ9vyEfA.jpg',
            'https://template.canva.com/EADjRj27UB8/1/0/225w-bSyQzphHdtQ.jpg',
            'https://template.canva.com/EAD3Z-S-3z8/2/0/225w-jrzCSU8c-6I.jpg',
            'https://template.canva.com/EADiaZyz038/1/0/225w-sNgPPklxbiY.jpg',
            'https://template.canva.com/EAELNUngteg/1/0/225w-Fo3mjPaMc4k.jpg',
            'https://template.canva.com/EAEAnhQ3owI/1/0/225w-gcIpkEXa6_Q.jpg',
            'https://template.canva.com/EADajryFLr0/4/0/225w-wE1zst0Sr14.jpg',
            'https://template.canva.com/EADaokZWm4Y/2/0/225w-NzrqWTYiDjM.jpg',
            'https://template.canva.com/EAD3Z9K7bx4/2/0/225w-mbj2rkGIqiI.jpg',
            'https://template.canva.com/EADanplyiEg/3/0/225w-TiRUVCSIBnY.jpg',
            'https://template.canva.com/EADaoRwL2vk/4/0/225w--nwrHOo-mwE.jpg',
            'https://template.canva.com/EAEFHbPI6Xo/1/0/225w-nIv1Z4LLd7g.jpg',
            'https://template.canva.com/EAEKB2UXzS0/1/0/225w-h1dSufnEsYA.jpg',
            'https://template.canva.com/EAD2YV60zZ8/1/0/225w-sgC_dRKa8MY.jpg',
            'https://template.canva.com/EAD5ZiRydZI/1/0/225w-i_0HZmZPIgk.jpg',
            'https://template.canva.com/EADaoN0AdO4/3/0/225w-ZPACc1gthfI.jpg',
            'https://template.canva.com/EAD2w8CYEKw/1/0/225w-Ud7wnCmeeEs.jpg',
            'https://template.canva.com/EADyWOSxxRA/1/0/225w-UwJuiqwDEcM.jpg',
            'https://template.canva.com/EADhrYPvmH4/1/0/225w-u2cm0w7EV9k.jpg',
            'https://template.canva.com/EAEDJXeyyzM/1/0/225w-txe9V2dH1BU.jpg',
            'https://template.canva.com/EAELwKTbW38/2/0/225w--jrkiSfVE18.jpg',
            'https://template.canva.com/EADyXOx8Voc/1/0/225w-LSuJJqKw3s0.jpg',
            'https://template.canva.com/EAD9m6qwLo4/2/0/225w-f43yl2DjdTE.jpg',
            'https://template.canva.com/EADaoW0zQvM/4/0/225w-GAr9wE7tuxU.jpg',
            'https://template.canva.com/EADibk__9pc/1/0/225w-aDerFitwFWA.jpg',
            'https://template.canva.com/EAEFHq0SprU/1/0/225w-egLYW_sRVC0.jpg',
            'https://template.canva.com/EADtqnlrEiI/4/0/225w-9ySnevm656w.jpg',
            'https://template.canva.com/EAEAoOjHykY/1/0/225w-CDVzTLajXME.jpg',
            'https://template.canva.com/EAD1diTpUNA/1/0/225w-B8eDcKX2Xv0.jpg',
            'https://template.canva.com/EAEGJ1fhe4U/1/0/225w-50nv9xSlc4M.jpg',
            'https://template.canva.com/EADaomiH_fU/5/0/225w-z-hSEtTLzZo.jpg',
            'https://template.canva.com/EAEBLVid6vo/1/0/225w-rkJk1e6lkf4.jpg',
            'https://template.canva.com/EAELnveM-MY/1/0/225w-WttLflFnyoI.jpg',
            'https://template.canva.com/EAEHLPw0dRM/2/0/225w-e00C5RIVMz8.jpg',
            'https://template.canva.com/EADaijy_1fU/2/0/225w-ekZJSnOQF6U.jpg',
            'https://template.canva.com/EAEFHWvK7Fs/1/0/225w-qqO0dPfwEWY.jpg',
            'https://template.canva.com/EAEGJ0XmJkw/1/0/225w-RuoGyILPC68.jpg',
            'https://template.canva.com/EADyV1SDMdw/1/0/225w-JhhBvA-MXfw.jpg',
            'https://template.canva.com/EADaiFe5fPc/2/0/225w-pIWD-A5kvk4.jpg',
            'https://template.canva.com/EADaoOGui3k/2/0/225w-PxG7VCyyKZE.jpg',
            'https://template.canva.com/EADgdlGkur8/1/0/225w-NjUJ4zxUhDw.jpg',
            'https://template.canva.com/EAEPFnryK-4/1/0/225w-kjt_OHAa9VQ.jpg',
            'https://template.canva.com/EAEPAvvChpQ/2/0/225w-IIoEc0ijsOM.jpg',
            'https://template.canva.com/EAD8re8qyL4/1/0/225w-1mm82-bnS_A.jpg',
            'https://template.canva.com/EAD8wpOxPa4/1/0/225w-4CJg2rF2p6Y.jpg',
            'https://template.canva.com/EAD8wTh3JNU/1/0/225w-q8pym1Bot-0.jpg',
            'https://template.canva.com/EAD8wD49rBs/1/0/225w-9zRAgQZ3wWc.jpg',
            'https://template.canva.com/EAD8wHEpFAA/1/0/225w-q7Sfd_phZ2c.jpg',
            'https://template.canva.com/EAD8wBovEx4/1/0/225w-5b60aH6Q-Tc.jpg',
            'https://template.canva.com/EADi-kZa3x0/1/0/225w-A0bA72MHa0Y.jpg',
            'https://template.canva.com/EAD8wOveo_g/1/0/225w-GIS0pLT3LXw.jpg',
            'https://template.canva.com/EAD8rTqnwsQ/1/0/225w-Tnrm-jUwIAg.jpg',
            'https://template.canva.com/EADan1zPHmQ/1/0/283w-74PbZSV7Gtk.jpg',
            'https://template.canva.com/EADaotUWU2I/1/0/283w-9lYPIwlEpRU.jpg',
            'https://template.canva.com/EADajw9gaaE/1/0/283w-Wsf7xDMR9kE.jpg',
            'https://template.canva.com/EADao4-jEZY/1/0/283w-OpNfuktE6Eo.jpg',
            'https://template.canva.com/EADaik4DH-8/1/0/283w-0JyXRkTEGg8.jpg',
            'https://template.canva.com/EADapDivTcI/1/0/283w-6v0kEJK-Mjo.jpg',
            'https://template.canva.com/EADaoga7E_0/1/0/283w-jUyow7yZDo4.jpg',
            'https://template.canva.com/EADajqzfbFM/1/0/283w-ahUtWduYNKM.jpg',
            'https://template.canva.com/EADaiEjTraM/1/0/283w-CvA5B87Up5I.jpg',
            'https://template.canva.com/EADaib7M1po/1/0/283w-TzpILTLW3is.jpg',
            'https://template.canva.com/EADao9ZKVms/1/0/283w-g128dSxQzFQ.jpg',
            'https://template.canva.com/EADaogT2DaA/2/0/283w-zl7KRM2UWhw.jpg',
            'https://template.canva.com/EADaiIOzzyQ/1/0/283w-kcMSC8hyHuI.jpg',
            'https://template.canva.com/EADao9bJi2g/1/0/283w-gBy6g-K3YJ0.jpg',
            'https://template.canva.com/EADaosbz96o/1/0/283w-FM-6kl03iww.jpg',
            'https://template.canva.com/EADaowwzefM/1/0/283w-Qjf--N5qYx0.jpg',
            'https://template.canva.com/EADangXmZiI/3/0/283w-L9_tlliIc8A.jpg',
            'https://template.canva.com/EADaoahgDiM/1/0/283w-Uvbc4V9j6bU.jpg',
            'https://template.canva.com/EADajyoriOs/1/0/283w-kr7BFwaB64Y.jpg',
            'https://template.canva.com/EADaoKQlUbc/1/0/283w-dxnJyJhryzE.jpg',
            'https://template.canva.com/EADapBuShb8/1/0/283w-MafFD-xXOh8.jpg',
            'https://template.canva.com/EADajgdL7TU/1/0/283w-9SCzdB_6wpc.jpg'
        ];
        
        return $thumb_urls;
    }

    function downloadImage(  $local_img_path, $img_url ){
        
        $path_info = pathinfo($local_img_path);
        
        $path = $path_info['dirname'];

        // print_r("<pre>");
        // print_r($path_info['dirname']);
        // print_r($path);
        // print_r($path_info);
        // print_r($local_img_path);
        // exit;
    
        @mkdir($path, 0777, true);
    
        set_time_limit(0);
    
        //This is the file where we save the    information
        $fp = fopen ($local_img_path, 'w+');
    
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ","%20",$img_url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        // get curl response
        curl_exec($ch); 
        curl_close($ch);
        fclose($fp);
    }


    function curlImage($template_id, $img_url){
        set_time_limit(0);
        
        $img_url_info = pathinfo($img_url);
        
        // echo "<pre>";
        // print_r($img_url_info);
        // exit;
        
        $full_file_path = public_path( 'canva/design/template/'.$template_id.'/assets/'.$img_url_info['basename'] );
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];
        
        // echo "<pre>";
        // print_r($path_info);
        // print_r("<br>");
        // print_r($path);
        // exit;

        if( file_exists( $full_file_path )  == false ){
            
            print_r($full_file_path);
            print_r("\n");

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => $img_url,
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Host: template.canva.com",
                    "Cookie: __cf_bm=580a3f5ffd98383c5e98d0be0972e593b5c0af61-1606836060-1800-AXH0jGHH9zb+WGyPb61gGVuhDJ43+E/RGu1x7IGnCgmNfIsfpLc0Zonolelytp605IgVms9t2ANjLypK1m40WQ4=; CS=1; CUI=ZNCOk_kLZO_BC5VK0rW7sXecwVWxKL8B0Wqn3rUJt7sePIU1bKgEFcZTopeV4oYh6m-Fdg; __cfduid=d15cd53225c206defe0a8d61c8b64eebe1604892343",
                    "accept: image/webp,image/png,image/svg+xml,image/*;q=0.8,video/*;q=0.8,*/*;q=0.5",
                    "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 14_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) canvaeditor/3.80.0",
                    "accept-language: en-us",
                    "referer: https://www.canva.com/",
                    "Pragma: no-cache",
                    "Cache-Control: no-cache"
                ),
            ));
            curl_exec($curl);
            curl_close($curl);
            fclose($fp);
        }
    }


    function getCategories(){
        // $auth_token = 'eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..HsTjvBwUoWcG0CPH.ZL_UNTdO7M0UbCxNaqmjXtwss7RIznBfmbGM2lNbvBFUGx1I3Q27YNbbTa-QovyUMnIn56U4OFdX3FSusOmdcvCBc7bc_dQtUzC-RIqw8RSZ4_mV5VqqVIq-wkNd4GK3fYuAFgAi8qmb9WwX6_OMqjjKQmQscMc3Cr6665gfWN1vOeeYBp8cpkLjthC7V3qW8UfG13Ho9Omwwn2fs98MfbCcob6J2JllYKHsNjvY6VPeADS6KMKhHgcid4feXpCfFuUjQjVYe9-3srUDywwyKH9-jT6VHN0eQYtbLEDfQrQeI9E54ub0jMBcH322c1OG9ugcab4AcT973hrENlxBtaS3ToVPX3FwHJ-b77hw8hV8e9pIOqrZ0O8bEkfDnT3tlIGZt9RlOuLzmWcxpT0hQyRHqfvis7gKhiFFQeoq6VTlDp3OeCuGLIcmsNaUowY5Dxp5yuM3T79RGeFlvZjq-LGJ645ozh1IA8mjM4T6W1_IrDOAbzKm-hXdtADx-7xGUAsgvjFmkcpvLVgKGb8Wi9rpYGwP-xg9kqPxaXPV1wQoGM6nUtqFtp8yvDyMw7Hu0tkmWiKkJhqN83WUEmfNpNFmTg9gfxKAcJWWJg5FR69kuZSIWTYHvDPacj5C4buOgQ8ynrfOB2ov0G6NZ1Yj3ZUy1LI7FiDK5CSby0vObAd32DXMMJBKJhTVyjvB6S7XYIze3y-UYLyKDXpCu398sQ0E_AG8ixz8ZX6l.Bz23_GRoIVIeYy_jZbao-g';

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.overhq.com/feed/quickstart",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "Host: api.overhq.com",
        //         "accept: application/json",
        //         "content-type: application/json",
        //         "accept-language: en-MX;q=1.0, es-MX;q=0.9",
        //         "over-lang: en",
        //         "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
        //         "over-auth: $auth_token"
        //     ),
        // ));

        // $response = curl_exec($curl); 
        // Redis::set('over:categories', $response);
        // curl_close($curl);

        $response = Redis::get('over:categories');
        $response = json_decode($response);

        
        echo "<pre>";
        print_r($response);

        return $response;

    }


    function saveCategoryOnDB($category_id, $offset = 0){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.overhq.com/feed/quickstart/$category_id?limit=100&offset=$offset&refresh=0",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: api.overhq.com",
            "accept: application/json",
            "content-type: application/json",
            "accept-language: en-MX;q=1.0, es-MX;q=0.9",
            "over-lang: en",
            "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
            "over-auth: eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..HsTjvBwUoWcG0CPH.ZL_UNTdO7M0UbCxNaqmjXtwss7RIznBfmbGM2lNbvBFUGx1I3Q27YNbbTa-QovyUMnIn56U4OFdX3FSusOmdcvCBc7bc_dQtUzC-RIqw8RSZ4_mV5VqqVIq-wkNd4GK3fYuAFgAi8qmb9WwX6_OMqjjKQmQscMc3Cr6665gfWN1vOeeYBp8cpkLjthC7V3qW8UfG13Ho9Omwwn2fs98MfbCcob6J2JllYKHsNjvY6VPeADS6KMKhHgcid4feXpCfFuUjQjVYe9-3srUDywwyKH9-jT6VHN0eQYtbLEDfQrQeI9E54ub0jMBcH322c1OG9ugcab4AcT973hrENlxBtaS3ToVPX3FwHJ-b77hw8hV8e9pIOqrZ0O8bEkfDnT3tlIGZt9RlOuLzmWcxpT0hQyRHqfvis7gKhiFFQeoq6VTlDp3OeCuGLIcmsNaUowY5Dxp5yuM3T79RGeFlvZjq-LGJ645ozh1IA8mjM4T6W1_IrDOAbzKm-hXdtADx-7xGUAsgvjFmkcpvLVgKGb8Wi9rpYGwP-xg9kqPxaXPV1wQoGM6nUtqFtp8yvDyMw7Hu0tkmWiKkJhqN83WUEmfNpNFmTg9gfxKAcJWWJg5FR69kuZSIWTYHvDPacj5C4buOgQ8ynrfOB2ov0G6NZ1Yj3ZUy1LI7FiDK5CSby0vObAd32DXMMJBKJhTVyjvB6S7XYIze3y-UYLyKDXpCu398sQ0E_AG8ixz8ZX6l.Bz23_GRoIVIeYy_jZbao-g"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo $response;
        $obj_response = json_decode($response);
        
        if($obj_response->elementList->count > 0){
            Redis::set('over:category:'.$category_id.':offset:'.$offset, $response);
            return true;
        }

        return false;

    }

    function generateDownloadPage($template_id){
        
        set_time_limit(0);

        $full_file_path = public_path('over/templates/'.$template_id.'.zip');
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];
        
        // echo "file_path\n\n\n\n";
        // echo $full_file_path;
        // echo "info\n\n\n\n";
        // print_r($path);
        // exit;
        if( file_exists( $full_file_path )  == false ){
            
            $curl = curl_init();
            
            @mkdir($path, 0777, true);
        
            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');
    
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.overhq.com/element/$template_id/asset",
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Host: api.overhq.com",
                    "accept: */*",
                    "over-lang: en",
                    "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
                    "over-auth: eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..HsTjvBwUoWcG0CPH.ZL_UNTdO7M0UbCxNaqmjXtwss7RIznBfmbGM2lNbvBFUGx1I3Q27YNbbTa-QovyUMnIn56U4OFdX3FSusOmdcvCBc7bc_dQtUzC-RIqw8RSZ4_mV5VqqVIq-wkNd4GK3fYuAFgAi8qmb9WwX6_OMqjjKQmQscMc3Cr6665gfWN1vOeeYBp8cpkLjthC7V3qW8UfG13Ho9Omwwn2fs98MfbCcob6J2JllYKHsNjvY6VPeADS6KMKhHgcid4feXpCfFuUjQjVYe9-3srUDywwyKH9-jT6VHN0eQYtbLEDfQrQeI9E54ub0jMBcH322c1OG9ugcab4AcT973hrENlxBtaS3ToVPX3FwHJ-b77hw8hV8e9pIOqrZ0O8bEkfDnT3tlIGZt9RlOuLzmWcxpT0hQyRHqfvis7gKhiFFQeoq6VTlDp3OeCuGLIcmsNaUowY5Dxp5yuM3T79RGeFlvZjq-LGJ645ozh1IA8mjM4T6W1_IrDOAbzKm-hXdtADx-7xGUAsgvjFmkcpvLVgKGb8Wi9rpYGwP-xg9kqPxaXPV1wQoGM6nUtqFtp8yvDyMw7Hu0tkmWiKkJhqN83WUEmfNpNFmTg9gfxKAcJWWJg5FR69kuZSIWTYHvDPacj5C4buOgQ8ynrfOB2ov0G6NZ1Yj3ZUy1LI7FiDK5CSby0vObAd32DXMMJBKJhTVyjvB6S7XYIze3y-UYLyKDXpCu398sQ0E_AG8ixz8ZX6l.Bz23_GRoIVIeYy_jZbao-g",
                    "accept-language: en-MX;q=1.0, es-MX;q=0.9"
                ),
            ));
    
            curl_exec($curl);
    
            curl_close($curl);
    
            fclose($fp);
        }
        
    }

    
}
