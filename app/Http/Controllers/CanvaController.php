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
            'https://template.canva.com/EADaoMckL5o/1/0/400w-IEp57xq6-ms.jpg',
            'https://template.canva.com/EADajl_IwiY/2/0/400w-HeVBD28GO88.jpg',
            'https://template.canva.com/EADajkJztIU/1/0/400w-78P8-dikzyU.jpg',
            'https://template.canva.com/EADapEpllgo/1/0/400w-L6qTRUnGtfI.jpg',
            'https://template.canva.com/EADanuK8LCo/1/0/400w-2p_BhT7hidA.jpg',
            'https://template.canva.com/EADahxJFZ_4/2/0/400w-rUlWzuLB2vg.jpg',
            'https://template.canva.com/EADapLIcy6o/2/0/400w-GTGAg6-WRyc.jpg',
            'https://template.canva.com/EADaotxEvW4/1/0/400w-XY4278_9JaI.jpg',
            'https://template.canva.com/EADaoy6iz64/1/0/400w-Y1PktFUo1Nc.jpg',
            'https://template.canva.com/EADajpIOjWM/1/0/400w-3SL848L5lls.jpg',
            'https://template.canva.com/EADaob6uGWc/1/0/400w-hTixw9_81Nw.jpg',
            'https://template.canva.com/EADan7Z2N8E/1/0/400w-iP5QZQj3f9I.jpg',
            'https://template.canva.com/EADaoP_yfrs/1/0/400w-dhRpJX0Mfuc.jpg',
            'https://template.canva.com/EADaoy7ga3s/1/0/400w-DpJZSghZkaY.jpg',
            'https://template.canva.com/EADao2gy2hk/1/0/400w--AK0j7QSCD0.jpg',
            'https://template.canva.com/EADanu_KTtY/3/0/400w-pGP2yLCm8-o.jpg',
            'https://template.canva.com/EADaoCbNrm4/1/0/400w-sC4f9EyvakE.jpg',
            'https://template.canva.com/EADao4V76Xc/1/0/400w-ecOlGaTyPDw.jpg',
            'https://template.canva.com/EADajtK3Ryg/2/0/400w-EXQZyVB9thQ.jpg',
            'https://template.canva.com/EADaoPzOM98/1/0/400w-X4xWyB42GsA.jpg',
            'https://template.canva.com/EADao0qNel4/2/0/400w-Tt4thsFQ75I.jpg',
            'https://template.canva.com/EADapI9E69c/2/0/400w-IDuVbasnyhk.jpg',
            'https://template.canva.com/EADaohcpXLw/1/0/400w-CTwvUdBbOXs.jpg',
            'https://template.canva.com/EADaiH4gB2w/1/0/400w-kml_mhaAjIE.jpg',
            'https://template.canva.com/EADanjsInZw/1/0/400w-n9mZw8C0Dkk.jpg',
            'https://template.canva.com/EADapDKVrfs/2/0/400w-5_ZI1HrFSdM.jpg',
            'https://template.canva.com/EADaokFyg6I/3/0/400w--kHhm31InPs.jpg',
            'https://template.canva.com/EADaoQaTHUE/2/0/400w-Ter_N10L9qU.jpg',
            'https://template.canva.com/EADaj40B9W8/1/0/400w-XPBrBxm22tU.jpg',
            'https://template.canva.com/EADanloVeUQ/2/0/400w-_yKNeJuuBTc.jpg',
            'https://template.canva.com/EADaom7__MM/1/0/400w-l7mvw-Gdka0.jpg',
            'https://template.canva.com/EADaoc7UWOA/2/0/400w-5ZCiNJajfwQ.jpg',
            'https://template.canva.com/EADaiGeCx5c/1/0/400w-PV1_f1Im0jg.jpg',
            'https://template.canva.com/EADaozuDL5E/1/0/400w-NR9HhUawKGg.jpg',
            'https://template.canva.com/EAEOf5J78s4/1/0/400w-sPMYU3fbdXA.jpg',
            'https://template.canva.com/EADaoWEwHN4/1/0/400w-MaMqSt2YMBQ.jpg',
            'https://template.canva.com/EADaogcoiH0/2/0/400w-bPVs98oJ4fY.jpg',
            'https://template.canva.com/EADajnqWu1M/1/0/400w-Sw-y-2ytGSY.jpg',
            'https://template.canva.com/EADaoQy7Lbw/1/0/400w-5mDpkxkzprU.jpg',
            'https://template.canva.com/EADao1B2oRE/1/0/400w-rZIhV93Thb8.jpg',
            'https://template.canva.com/EADao6SqJbU/1/0/400w--PR3JVzEsKU.jpg',
            'https://template.canva.com/EADaic1Behw/1/0/400w-ckJr7EEexIo.jpg',
            'https://template.canva.com/EADajh2rLPY/1/0/400w-Ieziakg09Ns.jpg',
            'https://template.canva.com/EADao0nejAE/1/0/400w-vTSWMe4jI0Q.jpg',
            'https://template.canva.com/EADaoDgF2Yo/1/0/400w-rM2vWW3cT6Q.jpg',
            'https://template.canva.com/EAEOf7hd6nI/1/0/400w-qOBIx6fv5yI.jpg',
            'https://template.canva.com/EADapJP4qEs/1/0/400w-4If1vx4GM48.jpg',
            'https://template.canva.com/EADaogjRkjc/2/0/400w-DL0RzVemYZE.jpg',
            'https://template.canva.com/EADaohK1gZo/2/0/400w-op5gbaYRlNQ.jpg',
            'https://template.canva.com/EADaonjIG58/1/0/400w-THwplg2wLbI.jpg',
            'https://template.canva.com/EADanyUFCoc/1/0/400w-M3RaDftLUeg.jpg',
            'https://template.canva.com/EADaoxHXZ2g/1/0/400w-Toy3wgj1sH8.jpg',
            'https://template.canva.com/EADajrDLx1k/1/0/400w-hWsThK-vYys.jpg',
            'https://template.canva.com/EADapFUDHms/1/0/400w-RkhCU_lCyBE.jpg',
            'https://template.canva.com/EADaob3GU28/1/0/400w-kURrcuGJXBY.jpg',
            'https://template.canva.com/EADaowM35Xc/2/0/400w-KY68JnSYjB4.jpg',
            'https://template.canva.com/EADapLFsKpE/1/0/400w-G-CQApkvym0.jpg',
            'https://template.canva.com/EADapHaf0jM/1/0/400w-ibQtfOpCIco.jpg',
            'https://template.canva.com/EADao4Ds8ek/1/0/400w-jZysX1vY5QU.jpg',
            'https://template.canva.com/EADao2ObOzw/2/0/400w-RCiWLSKkVSU.jpg',
            'https://template.canva.com/EADaiOGs_nw/2/0/400w-sjm_6WUc9AM.jpg',
            'https://template.canva.com/EADapDBeFFQ/1/0/400w-1aahKyZcNjQ.jpg',
            'https://template.canva.com/EADao_5Tehk/2/0/400w-ylwjaXK6VPs.jpg',
            'https://template.canva.com/EADaouq-YXU/1/0/400w-bv86mSUc_hQ.jpg',
            'https://template.canva.com/EADao0Q6liA/1/0/400w-5XZHTjzfhOM.jpg',
            'https://template.canva.com/EAEOf3QLvGE/1/0/400w-KBw4Pjm3LEc.jpg',
            'https://template.canva.com/EADao_GtIQo/1/0/400w-HgVwLeWVO-Y.jpg',
            'https://template.canva.com/EADaouAkV8c/2/0/400w-TanBi5_d2lU.jpg',
            'https://template.canva.com/EADaoAyEsEE/2/0/400w-Tm_SXU1RGWQ.jpg',
            'https://template.canva.com/EADao4tH3pU/1/0/400w-to6ujGxofdo.jpg',
            'https://template.canva.com/EADan96Izqc/1/0/400w-T4HbbCLPkhA.jpg',
            'https://template.canva.com/EADaobkgVtw/1/0/400w-ahDimjEoa6U.jpg',
            'https://template.canva.com/EADaoLqI5NM/2/0/400w-PsVs7Rr38c4.jpg',
            'https://template.canva.com/EADanxYgyyY/1/0/400w-n86UxdE-ysU.jpg',
            'https://template.canva.com/EADaiSpSRFU/1/0/400w-y5lxd2UGvQE.jpg',
            'https://template.canva.com/EADao41BFmk/1/0/400w--6VXtJNZ2TY.jpg',
            'https://template.canva.com/EADapAgTBQY/2/0/400w-1WKMuLeZwBU.jpg',
            'https://template.canva.com/EADaoVqmY-A/1/0/400w-ed6o1uetw-0.jpg',
            'https://template.canva.com/EADapLkrAaQ/3/0/400w-obt8rCoM564.jpg',
            'https://template.canva.com/EADah2JgBjs/2/0/400w-Jv6Lquv4-tA.jpg',
            'https://template.canva.com/EADaj0ee978/2/0/400w-BpnWDac1fdc.jpg',
            'https://template.canva.com/EADaohInQY8/1/0/400w-4ZR9mbtLVK8.jpg',
            'https://template.canva.com/EADajU5XRug/1/0/400w-24UqlRbLnzg.jpg',
            'https://template.canva.com/EADao6HZ6Wc/2/0/400w-nUTf9qtxgV4.jpg',
            'https://template.canva.com/EADaoXslmEY/1/0/400w-AxaUB9UUQm8.jpg',
            'https://template.canva.com/EADaof2Jqow/2/0/400w-mK_eJii0RYI.jpg',
            'https://template.canva.com/EADaoUOrHrM/2/0/400w-padaPG6Dc3U.jpg',
            'https://template.canva.com/EADajyeWMVQ/3/0/400w-HrBMLVQImEU.jpg',
            'https://template.canva.com/EADan3s8rL8/1/0/400w-I5vhm06OrUc.jpg',
            'https://template.canva.com/EADapBDVhU8/2/0/400w-SBPiRrsmylw.jpg',
            'https://template.canva.com/EADao40zLuw/2/0/400w-qgnI5yvL5mE.jpg',
            'https://template.canva.com/EADaooqL4b4/1/0/400w-RVoMwG4aNaU.jpg',
            'https://template.canva.com/EADaor-U7zY/3/0/400w-XBv264zM8U0.jpg',
            'https://template.canva.com/EADaoug6vgs/1/0/400w-4S5PSkFTlVI.jpg',
            'https://template.canva.com/EADanzja-ZI/1/0/400w-Md--68b-3Xo.jpg',
            'https://template.canva.com/EADanm7IQlQ/2/0/400w-Jt_R0tWskrg.jpg',
            'https://template.canva.com/EADaoogCav4/1/0/400w-KNKg3515KV8.jpg',
            'https://template.canva.com/EADaouEo8jg/1/0/400w-Aok_Uq-sgec.jpg',
            'https://template.canva.com/EADanwLS7Q4/2/0/400w-sdgI6RDdZmM.jpg',
            'https://template.canva.com/EADaiq9AMHg/1/0/400w-MBCnVMDOTvQ.jpg',
            'https://template.canva.com/EADaoIjLqRQ/1/0/400w-sFkIe639eAw.jpg',
            'https://template.canva.com/EADaoJDfFM8/2/0/400w-5uBEvYMQwos.jpg',
            'https://template.canva.com/EAEOf7i2F7g/1/0/400w-3CrAJxnN0vo.jpg',
            'https://template.canva.com/EADanpmrzCY/1/0/400w-5Pizs-sgajE.jpg',
            'https://template.canva.com/EADao8X5ZEo/1/0/400w-SlqsnwhB25E.jpg',
            'https://template.canva.com/EAEOf3RES_M/1/0/400w-v9HSvk6bngA.jpg',
            'https://template.canva.com/EADaiDmxOFE/1/0/400w-Bjh2M2P3bHQ.jpg',
            'https://template.canva.com/EADaod_poAM/1/0/400w-rDdGMwyd6fI.jpg',
            'https://template.canva.com/EADao89v8Nk/1/0/400w-T1R0DVVroqg.jpg',
            'https://template.canva.com/EADapPX_w_c/1/0/400w-N2RmPtyGz8U.jpg',
            'https://template.canva.com/EADapF6XrQs/1/0/400w-g3Ph0f8eafI.jpg',
            'https://template.canva.com/EADaoZss5-o/1/0/400w-S4kEXexwOXA.jpg',
            'https://template.canva.com/EADaiS1O-bc/1/0/400w-99ZymT0B0Qk.jpg',
            'https://template.canva.com/EAEOf0YynxE/1/0/400w-f8eFKJDbPpY.jpg',
            'https://template.canva.com/EADan8fcMQE/1/0/400w-2b-qlx-enog.jpg',
            'https://template.canva.com/EADao2O6Xvk/2/0/400w-pAUmjmUnenk.jpg',
            'https://template.canva.com/EADaop0qY7Y/1/0/400w-Yp5n_Ts4msk.jpg',
            'https://template.canva.com/EADaomRmbDw/1/0/400w-6J-6zfwlGQY.jpg',
            'https://template.canva.com/EADaoP2WZ40/2/0/400w-0Nfv_EXYnkU.jpg',
            'https://template.canva.com/EADao3305vA/1/0/400w-zip8p_ZGOxs.jpg',
            'https://template.canva.com/EADaj4ydSzc/1/0/400w-SaIeSxXG4Jk.jpg',
            'https://template.canva.com/EADaopBB19g/2/0/400w-Y9CLKj69ems.jpg',
            'https://template.canva.com/EADaouRPxPM/2/0/400w-NuJAlvnrnUU.jpg',
            'https://template.canva.com/EADanyRcvu8/2/0/400w-aIHiqzmqBVI.jpg',
            'https://template.canva.com/EADao9uam8g/1/0/400w-USkc6N988I0.jpg',
            'https://template.canva.com/EADan4OVKTg/1/0/400w-pGYJMpQnxtg.jpg',
            'https://template.canva.com/EADaokpFjyw/1/0/400w-J3vt13H-URE.jpg',
            'https://template.canva.com/EADaiTkJRHI/2/0/400w-C92nwWUrVc8.jpg',
            'https://template.canva.com/EADapK4clTI/1/0/400w-4lEEaHD4J6A.jpg',
            'https://template.canva.com/EADaobGIhGU/1/0/400w-IjQVYru6d5E.jpg',
            'https://template.canva.com/EADapGRqrKM/2/0/400w-SdDB0Tg4rLc.jpg',
            'https://template.canva.com/EADapAiSono/1/0/400w-rggmezokJZ8.jpg',
            'https://template.canva.com/EADaogQZzEk/1/0/400w-8WQ4Z8qbWa4.jpg',
            'https://template.canva.com/EADaiTLyMcs/1/0/400w-ExiStBDNRKM.jpg',
            'https://template.canva.com/EADan2KohAk/3/0/400w-NyDf0RnVj9c.jpg',
            'https://template.canva.com/EADaozj4CYs/1/0/400w-o1GSu0otUtI.jpg',
            'https://template.canva.com/EADaobQpsus/2/0/400w-IsFqJgrLEPU.jpg',
            'https://template.canva.com/EADapGYMyS4/1/0/400w--klPuTdIIz0.jpg',
            'https://template.canva.com/EADaor4RSJY/4/0/400w-RP0otvMQeIA.jpg',
            'https://template.canva.com/EADaoF1WLuw/1/0/400w-0Y9tZ60jXQo.jpg',
            'https://template.canva.com/EADaoINmzAc/2/0/400w-1yhct1zYWe0.jpg',
            'https://template.canva.com/EADajXpQ3yQ/1/0/400w-5ErI6_XWuoI.jpg',
            'https://template.canva.com/EADaj0ECKXY/1/0/400w-Z1F9jcdXmvk.jpg',
            'https://template.canva.com/EADaoICKMVg/1/0/400w-iRjEADWj4sA.jpg',
            'https://template.canva.com/EADakLXfd2Y/4/0/400w-bjPB0VOEOWc.jpg',
            'https://template.canva.com/EADaooebBkk/1/0/400w-h0Tn8QLjt5k.jpg',
            'https://template.canva.com/EADao2aLgMU/1/0/400w-5SfO_oyynkQ.jpg',
            'https://template.canva.com/EADao2YYhFs/1/0/400w-g8bavHa5g8M.jpg',
            'https://template.canva.com/EADaoiXGgec/1/0/400w-ziXkU4FOBDY.jpg',
            'https://template.canva.com/EADaoPCHGNc/1/0/400w-aUvYrD8fibk.jpg',
            'https://template.canva.com/EADaoLZZptI/1/0/400w-V1bzOY3mcHE.jpg',
            'https://template.canva.com/EADaodXbHpg/3/0/400w-xOHwharT26g.jpg',
            'https://template.canva.com/EADaoCQxQGw/1/0/400w-sko81bLGIko.jpg',
            'https://template.canva.com/EADanzZ0dRY/1/0/400w-AFpQjgEVmKI.jpg',
            'https://template.canva.com/EADaosSR-UI/1/0/400w-ak4kLLuZa_M.jpg',
            'https://template.canva.com/EADapKMk6lw/1/0/400w-I67ECzc_pUY.jpg',
            'https://template.canva.com/EADaoMwzXko/1/0/400w-gXSRom_CRkk.jpg',
            'https://template.canva.com/EADaiRxXfNI/1/0/400w-h-U8cpWfPS8.jpg',
            'https://template.canva.com/EAEOf9hN6UE/1/0/400w-ty7M4NkAJx0.jpg',
            'https://template.canva.com/EADaolTi8SM/1/0/400w-rCx4sOjrlJ8.jpg',
            'https://template.canva.com/EADapKoQyGc/2/0/400w-ju0rn2QmClQ.jpg',
            'https://template.canva.com/EADao8zvi98/1/0/400w-CKFkUS2GnNQ.jpg',
            'https://template.canva.com/EADaoK5Cdts/1/0/400w-NI-5zj3l82Q.jpg',
            'https://template.canva.com/EADaoZk56YA/1/0/400w-xpXcqmtDJTM.jpg',
            'https://template.canva.com/EADapAweixc/2/0/400w-ZIGcRahGjIk.jpg',
            'https://template.canva.com/EADapG1UTrc/2/0/400w-N2WDF4Mv1Ts.jpg',
            'https://template.canva.com/EADan_82aQw/1/0/400w-FxCudArKqns.jpg',
            'https://template.canva.com/EAEOf_Qsj48/1/0/400w-FLIy56yYc-0.jpg',
            'https://template.canva.com/EADaouIph0g/1/0/400w-hXjChujfMTk.jpg',
            'https://template.canva.com/EADao56wA7w/1/0/400w-hSTza-ABcDg.jpg',
            'https://template.canva.com/EADapDomoRQ/1/0/400w-aW8l74Y3Pas.jpg',
            'https://template.canva.com/EADaoK45aL8/2/0/400w-sfXBqT9RGCY.jpg',
            'https://template.canva.com/EADaoukiF24/1/0/400w-6pTQEsuuWvU.jpg',
            'https://template.canva.com/EADaj0XJOMs/3/0/400w-Re2ELJx_Rno.jpg',
            'https://template.canva.com/EADaja07GvY/1/0/400w-0FM10SINGGs.jpg',
            'https://template.canva.com/EADao2wghwM/1/0/400w-XBOqgYyVALk.jpg',
            'https://template.canva.com/EADanuDZv5Q/2/0/400w-3GyOhl1stfY.jpg',
            'https://template.canva.com/EAEOf_GZfC4/1/0/400w-CJNThoXgCLc.jpg',
            'https://template.canva.com/EADaiqYtV3w/1/0/400w-W9WSvpB_z6Y.jpg',
            'https://template.canva.com/EADaoXLCGzw/2/0/400w-J1mvqsEnshA.jpg',
            'https://template.canva.com/EADaiIpj65k/2/0/400w-d2w8PtFlx6M.jpg',
            'https://template.canva.com/EADapOCxO_g/1/0/400w-ek6c1yyPaAE.jpg',
            'https://template.canva.com/EADaooMMEps/1/0/400w-du7szW6z5YQ.jpg',
            'https://template.canva.com/EADaoDwCPT8/1/0/400w-KuoECQRkI_s.jpg',
            'https://template.canva.com/EADaieuwZfA/1/0/400w--D9gio2pOEo.jpg',
            'https://template.canva.com/EADapJhcoto/2/0/400w-HQu61ThSQaM.jpg',
            'https://template.canva.com/EADaoyxLgvQ/2/0/400w-T3B7-sc1L6g.jpg',
            'https://template.canva.com/EADaormIYME/1/0/400w-XRrivILPjSc.jpg',
            'https://template.canva.com/EADah6iBBG0/1/0/400w-YavnIfdZTq4.jpg',
            'https://template.canva.com/EADaoN2U0l0/1/0/400w-_I40OQVnaGo.jpg',
            'https://template.canva.com/EADaoBCHPg4/1/0/400w-Vxt4-EmOI7o.jpg',
            'https://template.canva.com/EADao6vYj1c/2/0/400w-CmkH9H_Qg8Y.jpg',
            'https://template.canva.com/EADaoc4WN7A/1/0/400w-H69hcLMmRHQ.jpg',
            'https://template.canva.com/EADaoIRkF_I/2/0/400w-bt-6GiteNMM.jpg',
            'https://template.canva.com/EADangI_bT0/1/0/400w-6PAq9IeZErY.jpg',
            'https://template.canva.com/EADaoqvLvb8/1/0/400w-oCrlv1sbR28.jpg',
            'https://template.canva.com/EADapK0AOsw/1/0/400w-HxmfIUMmvZE.jpg',
            'https://template.canva.com/EADan49MI3k/2/0/400w-M3GYnIWnAfU.jpg',
            'https://template.canva.com/EADaiAKPc0Q/1/0/400w-bltSRbSrBnI.jpg',
            'https://template.canva.com/EADaozPqH9I/2/0/400w-xVnuIR8MciA.jpg',
            'https://template.canva.com/EADao7uJ924/1/0/400w-n62JZojdGYY.jpg',
            'https://template.canva.com/EADao-K60OE/1/0/400w-zm-kG4GHuAU.jpg',
            'https://template.canva.com/EADaobP8aJE/2/0/400w-erTBt_I1RLc.jpg',
            'https://template.canva.com/EADaj41FLLE/1/0/400w-LFj7DdcE3q0.jpg',
            'https://template.canva.com/EADajy9UGg4/1/0/400w-C2h2vOv5gog.jpg',
            'https://template.canva.com/EADanx5xSpk/2/0/400w-qYOYkWR_vPg.jpg',
            'https://template.canva.com/EADanwla4AM/2/0/400w-JCC7J5dR13w.jpg',
            'https://template.canva.com/EADaoFR1k5U/1/0/400w-B5o72yvOFIw.jpg',
            'https://template.canva.com/EADaoIilgqA/1/0/400w-FRHAyviCHEo.jpg',
            'https://template.canva.com/EADapMPc8qQ/1/0/400w-WbXM4f7Kj60.jpg',
            'https://template.canva.com/EADanwFdjv8/1/0/400w-amGj3awOIyg.jpg',
            'https://template.canva.com/EADaonrGX0o/1/0/400w-Q1T74ygw6po.jpg',
            'https://template.canva.com/EADah2lKK7w/1/0/400w-VTioMdbBEwk.jpg',
            'https://template.canva.com/EADanxZ8qws/1/0/400w-zTQ3fzgX0NM.jpg',
            'https://template.canva.com/EADaotZEkNo/2/0/400w-SObdVE-SbmU.jpg',
            'https://template.canva.com/EAEOf4BVyiU/1/0/400w-NVfsT4lF1S4.jpg',
            'https://template.canva.com/EADaiQXgWNk/1/0/400w-F_cVKsSjWFg.jpg',
            'https://template.canva.com/EADajm4xbz0/1/0/400w-zcS_5uOQju0.jpg',
            'https://template.canva.com/EADakPJRIjE/1/0/400w-04XPjQ0Fqc8.jpg',
            'https://template.canva.com/EADaoDk8i0k/2/0/400w-6FcYHpJHOqo.jpg',
            'https://template.canva.com/EADaoqolGGE/1/0/400w-qmtJqQ8-xQk.jpg',
            'https://template.canva.com/EADapGtE1ho/2/0/400w-5qU4ovA5iEo.jpg',
            'https://template.canva.com/EADao6K2FFE/1/0/400w-TL4EZDmXLhI.jpg',
            'https://template.canva.com/EADajv8gJLo/1/0/400w-fL9thAmlPn8.jpg',
            'https://template.canva.com/EADapNQESAI/1/0/400w-H5-0YEkfMK0.jpg',
            'https://template.canva.com/EADaoaUQahE/2/0/400w-fHae6B4kgKk.jpg',
            'https://template.canva.com/EADah9mgaFw/1/0/400w-fGMFXuh-Lnw.jpg',
            'https://template.canva.com/EADao4KdQ0I/2/0/400w-PHXRKdYnjac.jpg',
            'https://template.canva.com/EADaiKVGPRU/1/0/400w-4sSbcJtcyt4.jpg',
            'https://template.canva.com/EADaoIVoJ5E/2/0/400w-XCq5AbnbXHY.jpg',
            'https://template.canva.com/EADaoIuaByg/2/0/400w-Ap0cXOkq1Q0.jpg',
            'https://template.canva.com/EADantgO0yo/1/0/400w-dTKwz7pBSxo.jpg',
            'https://template.canva.com/EADaj98D7dY/1/0/400w-aO-cJpmzqs8.jpg',
            'https://template.canva.com/EADaoeHadwc/2/0/400w-I0nJlseayHo.jpg',
            'https://template.canva.com/EADaiEhBAFU/1/0/400w-uhSg7mab2YI.jpg',
            'https://template.canva.com/EADaiX24b_Y/1/0/400w-8TzGgOqOgPk.jpg',
            'https://template.canva.com/EADaoX1iuDM/1/0/400w-oRC04-Yivr4.jpg',
            'https://template.canva.com/EADanztdpao/2/0/400w-YY3q6YpjEfc.jpg',
            'https://template.canva.com/EADaobWImPc/1/0/400w-xGLKvdajnOA.jpg',
            'https://template.canva.com/EADaiJsdNwg/2/0/400w-STSnzkWqwi0.jpg',
            'https://template.canva.com/EADaoNFh96I/2/0/400w-XmdcrKQPnNg.jpg',
            'https://template.canva.com/EADan1ijajo/1/0/400w-yMH0tYy1xCA.jpg',
            'https://template.canva.com/EADaobDrD60/2/0/400w-vrCb7z6L5fc.jpg',
            'https://template.canva.com/EADajzzhG2A/1/0/400w-1bzyVoNix2Y.jpg',
            'https://template.canva.com/EADaoMaNiII/2/0/400w-V0gsGHQIxHU.jpg',
            'https://template.canva.com/EADapD8v0CY/1/0/400w-UjwT-BG8qbc.jpg',
            'https://template.canva.com/EAD3-sDhQpU/2/0/400w-rNjBnXPsHsI.jpg',
            'https://template.canva.com/EADaosS7EUg/2/0/400w-hk0PS2IPUU8.jpg',
            'https://template.canva.com/EADao9WAwpA/1/0/400w-sMcNxXkul3U.jpg',
            'https://template.canva.com/EADanyHBvj4/1/0/400w-Bh-VLht8ZJ4.jpg',
            'https://template.canva.com/EADan30cqlk/3/0/400w-fZf48avdMco.jpg',
            'https://template.canva.com/EADaoq9qrzE/2/0/400w-56CvtOVugo4.jpg',
            'https://template.canva.com/EADaoNENpQU/2/0/400w-Xw9R1M8NmxY.jpg',
            'https://template.canva.com/EADao6zNk2E/1/0/400w-CUGvCQo7iis.jpg',
            'https://template.canva.com/EADaojZTQ5Y/2/0/400w-PaGZ1wM7ncU.jpg',
            'https://template.canva.com/EADaozOTsIA/1/0/400w-YMFWo9IzSM8.jpg',
            'https://template.canva.com/EADapDqSEgQ/1/0/400w-xaXKjhX0Mk0.jpg',
            'https://template.canva.com/EADaiUe_nLE/2/0/400w-_tcjU20JQoo.jpg',
            'https://template.canva.com/EADao_woOi0/2/0/400w-4Gu5LA2eXNA.jpg',
            'https://template.canva.com/EADaoj-dZao/1/0/400w-6nZtF3nsrSs.jpg',
            'https://template.canva.com/EADaomVQw_Q/1/0/400w-gs7OXJXzGNs.jpg',
            'https://template.canva.com/EADapFrwQtE/2/0/400w-9fGPJuRhwxI.jpg',
            'https://template.canva.com/EADaocv5H6A/3/0/400w-rX3jCprx-bk.jpg',
            'https://template.canva.com/EADaoQ9mr_8/2/0/400w-Q8JydExfl2I.jpg',
            'https://template.canva.com/EADaoL-DCrQ/1/0/400w-h0_sBpn6ATc.jpg',
            'https://template.canva.com/EADaiLJquVY/3/0/400w-r4zjpQ4GTiE.jpg',
            'https://template.canva.com/EADajoNuHfs/2/0/400w-WvqI1Ntp-X0.jpg',
            'https://template.canva.com/EADaj2qtHyk/1/0/400w-W5KkKN_z96c.jpg',
            'https://template.canva.com/EADajcsB9EI/1/0/400w-ejd9pV_WbbQ.jpg',
            'https://template.canva.com/EADaj2ujY9s/1/0/400w-TgbzmYO8GcU.jpg',
            'https://template.canva.com/EADaoaLth3g/1/0/400w-WFPHdSrY8q4.jpg',
            'https://template.canva.com/EADaovM0SZA/1/0/400w-mJXHy9l4fjA.jpg',
            'https://template.canva.com/EADaoyiCcwQ/1/0/400w-XFCdvzMA_yk.jpg',
            'https://template.canva.com/EADaou229Hs/1/0/400w-I7SzS6LO_HU.jpg',
            'https://template.canva.com/EADaoJZIHdw/2/0/400w-TlJ6h9Ehg0E.jpg',
            'https://template.canva.com/EADajr8lMIE/2/0/400w-9vaa3zO7E9U.jpg',
            'https://template.canva.com/EADan37oirk/1/0/400w-kKRO7W5vHPg.jpg',
            'https://template.canva.com/EADanrOR-Ng/1/0/400w-NHW82LQaKvk.jpg',
            'https://template.canva.com/EADapJe6cLQ/3/0/400w-kNJUb2o6qKI.jpg',
            'https://template.canva.com/EADaopTxYYg/1/0/400w-C5R7xrFvlx0.jpg',
            'https://template.canva.com/EADaoBGguBY/2/0/400w-aeydSTj_7Cg.jpg',
            'https://template.canva.com/EADaoOEB4xM/1/0/400w-hA8vPE5gPNM.jpg',
            'https://template.canva.com/EADao9f2e-w/1/0/400w-EKYKl7lTpqU.jpg',
            'https://template.canva.com/EADapAeIr_o/2/0/400w-YUwvv90Pl6Q.jpg',
            'https://template.canva.com/EADaogWXM7Y/1/0/400w-GD366k6ZqIQ.jpg',
            'https://template.canva.com/EADao0S-WVA/3/0/400w-dmlYSQcP5-o.jpg',
            'https://template.canva.com/EADanwYp_fo/2/0/400w-OMfPPwmmWfs.jpg',
            'https://template.canva.com/EADaopqDxwA/1/0/400w-cvElmjVbNj4.jpg',
            'https://template.canva.com/EADajgrvW8I/3/0/400w-wESdyYVkk5E.jpg',
            'https://template.canva.com/EADaoiqsZwM/1/0/400w-125Ripg1nww.jpg',
            'https://template.canva.com/EADao1H7p9E/1/0/400w-LrdC8aBocm0.jpg',
            'https://template.canva.com/EADajddajgM/1/0/400w-_sUMN2KvT0U.jpg',
            'https://template.canva.com/EADanrWo4qE/1/0/400w-bN7-vCFMPyQ.jpg',
            'https://template.canva.com/EADaoXXLeP8/1/0/400w-0jb_wDyR8gQ.jpg',
            'https://template.canva.com/EADaoAoL_EI/2/0/400w-U64d7emEuQE.jpg',
            'https://template.canva.com/EADaoSPr4wk/2/0/400w-lgAjCUPiVPM.jpg',
            'https://template.canva.com/EADan2eJoZk/2/0/400w-vTAt4ESYKyU.jpg',
            'https://template.canva.com/EADanzdUIOE/2/0/400w-Oy731lLn0P0.jpg',
            'https://template.canva.com/EADapNV13yc/2/0/400w-605KewkHWc0.jpg',
            'https://template.canva.com/EADaowR-ox4/3/0/400w-YT_Npifhqzc.jpg',
            'https://template.canva.com/EADaoJW1p2Y/2/0/400w-w4kgVql3eok.jpg',
            'https://template.canva.com/EADanydBJ6E/1/0/400w-flZ6c6_7YvM.jpg',
            'https://template.canva.com/EADaovztBu8/2/0/400w-7fSBwtYBee0.jpg',
            'https://template.canva.com/EADaj34bs4A/1/0/400w-tA8BBwWSuJ8.jpg',
            'https://template.canva.com/EADao4HpPOY/1/0/400w-lejoDwWay4g.jpg',
            'https://template.canva.com/EADajT5ZIbY/1/0/400w-_y9dhh66Iyo.jpg',
            'https://template.canva.com/EADaobR_tM4/1/0/400w-qJPDX4x4rfM.jpg',
            'https://template.canva.com/EADaiDsv7wg/1/0/400w-gbT0_xcLixc.jpg',
            'https://template.canva.com/EADaoaQBV80/1/0/400w-5336lYp5Nzc.jpg',
            'https://template.canva.com/EADaoVdv7Yk/1/0/400w-mZyJ4VUc-aI.jpg',
            'https://template.canva.com/EADaorM82Yo/1/0/400w-Xd2_XVF-2T8.jpg',
            'https://template.canva.com/EADaon42slk/2/0/400w-OovajTpDrK0.jpg',
            'https://template.canva.com/EADao7PbjC0/1/0/400w-1N8hLcgkLuo.jpg',
            'https://template.canva.com/EADajSlQKEU/2/0/400w-hOe87QkVOoQ.jpg',
            'https://template.canva.com/EADaoDtzUuM/1/0/400w-4mKyarVQ-6I.jpg',
            'https://template.canva.com/EADan9YjLmI/2/0/400w-1sLjeCRu2Qs.jpg',
            'https://template.canva.com/EADajYCpsKM/1/0/400w-3IeXqTGzfKQ.jpg',
            'https://template.canva.com/EADaows95Ck/2/0/400w-jg1je03xGdw.jpg',
            'https://template.canva.com/EADajvgtuK4/2/0/400w-ROBbJtegMZg.jpg',
            'https://template.canva.com/EAEOk7giPwA/1/0/400w-rSytbVW4evA.jpg',
            'https://template.canva.com/EADaoH_murc/1/0/400w-CQ1_dE6PKe4.jpg',
            'https://template.canva.com/EADapNf1O1A/2/0/400w-5OXVjaMEJ3Y.jpg',
            'https://template.canva.com/EADao7gwK14/1/0/400w-Ez681MELMR8.jpg',
            'https://template.canva.com/EADaoihb6Nw/3/0/400w-lrrtu12MzsM.jpg',
            'https://template.canva.com/EADao0LFSoU/1/0/400w-mSWhsB-zRkE.jpg',
            'https://template.canva.com/EADapNHW5DI/2/0/400w-f7VWlec_Ko8.jpg',
            'https://template.canva.com/EADaogH2_FQ/2/0/400w-7jxosfC_aqo.jpg',
            'https://template.canva.com/EADao2r9hgo/2/0/400w-FQ4-EnbbgTQ.jpg',
            'https://template.canva.com/EADaipuyNUE/1/0/400w-yIl82Xxvyls.jpg',
            'https://template.canva.com/EADaniMsfqs/1/0/400w-b4wufElykEI.jpg',
            'https://template.canva.com/EAEOf7r9ls8/1/0/400w-G1umuNmWo3c.jpg',
            'https://template.canva.com/EADaiHJY6w4/1/0/400w-Lf3E1CwZ75s.jpg',
            'https://template.canva.com/EADaomgSr6k/4/0/400w-VDUaIRuyz7Y.jpg',
            'https://template.canva.com/EADaockHoQs/3/0/400w-GwABJv1SZJI.jpg',
            'https://template.canva.com/EADanhvj8CI/1/0/400w-UxRDMwp8EGQ.jpg',
            'https://template.canva.com/EAEOk6lqLYE/1/0/400w-7y9pYopHVwI.jpg',
            'https://template.canva.com/EADaolOxbp0/1/0/400w-qdjTAYj27LE.jpg',
            'https://template.canva.com/EADao_F0bCk/1/0/400w-Pg69mu1LRbI.jpg',
            'https://template.canva.com/EADaoyF2Zdg/2/0/400w-Q1H4csfA7UY.jpg',
            'https://template.canva.com/EADao67Azi0/1/0/400w-75Ky7QDBHwU.jpg',
            'https://template.canva.com/EADajn8Uhg0/1/0/400w-_42PpuE_Vas.jpg',
            'https://template.canva.com/EADaopV9mPk/2/0/400w-1IGa-Mrmka8.jpg',
            'https://template.canva.com/EADaoh8Fxj0/1/0/400w-CwFQpskuKdQ.jpg',
            'https://template.canva.com/EADapObiMwU/2/0/400w-CL6sfy9JcjY.jpg',
            'https://template.canva.com/EADaopgA5Gg/1/0/400w-WB6zX4aTjuo.jpg',
            'https://template.canva.com/EADao2hkdNI/1/0/400w-JTVRZA5sNOc.jpg',
            'https://template.canva.com/EADaj0CVHI0/1/0/400w-VCML8neaFfQ.jpg',
            'https://template.canva.com/EADaoINLw1U/1/0/400w-JgUdzt6tcmQ.jpg',
            'https://template.canva.com/EAD_fP7C9EM/1/0/400w-V2JGMHEfR_M.jpg',
            'https://template.canva.com/EADaoqNTE30/1/0/400w-ahbVtrkCmsU.jpg',
            'https://template.canva.com/EADaom-GWTI/1/0/400w-dC89JTFCw0o.jpg',
            'https://template.canva.com/EADaoE5ftVs/1/0/400w-l_yBhzsU1Co.jpg',
            'https://template.canva.com/EADajvQObpg/1/0/400w-2yfUfdO-95A.jpg',
            'https://template.canva.com/EADao1Lht7k/2/0/400w--BENR1E3VQM.jpg',
            'https://template.canva.com/EADan1Y49A8/1/0/400w-xCr8_k_1BeQ.jpg',
            'https://template.canva.com/EADan6UxH-A/2/0/400w-UTk-t5N4Vr4.jpg',
            'https://template.canva.com/EADakOzEgcQ/1/0/400w-bsuqX7OEh0s.jpg',
            'https://template.canva.com/EADaor4GZDM/1/0/400w-QIN6azuo3Ek.jpg',
            'https://template.canva.com/EADairTfGaY/1/0/400w-FzWfIVUNiPA.jpg',
            'https://template.canva.com/EADapJxaxmc/2/0/400w-3nECfXdnMnI.jpg',
            'https://template.canva.com/EADao9mS9b8/1/0/400w-uyBbiuidK8E.jpg',
            'https://template.canva.com/EADaonCdJ0Q/1/0/400w-iG5yhftBwI8.jpg',
            'https://template.canva.com/EADaoMACnjM/2/0/400w-qpmHiMr3W0M.jpg',
            'https://template.canva.com/EADajsZDTGI/1/0/400w-wjmbqyjBrSI.jpg',
            'https://template.canva.com/EADaoh7UGz8/2/0/400w--SNaGZTWb28.jpg',
            'https://template.canva.com/EADan44GEqU/2/0/400w-U35cfORZQr8.jpg',
            'https://template.canva.com/EADajrx3Ems/2/0/400w-jUYdKoxsDyo.jpg',
            'https://template.canva.com/EADaoKkU7Io/1/0/400w-werOXpsvUhI.jpg',
            'https://template.canva.com/EADaormwRAw/3/0/400w-7IA0O4sh-9U.jpg',
            'https://template.canva.com/EADaj4D2qd4/2/0/400w-Uj3q2NkXW7Q.jpg',
            'https://template.canva.com/EADaj9N-rBo/1/0/400w-8wTOp6slpFA.jpg',
            'https://template.canva.com/EADaoBrrs_g/1/0/400w-7KPhqC-m7mU.jpg',
            'https://template.canva.com/EADapBgt3ZA/1/0/400w-bC954Fj8wHM.jpg',
            'https://template.canva.com/EADanlcSPCY/1/0/400w-HZv8e-aGI-8.jpg',
            'https://template.canva.com/EADaoCtQZrY/1/0/400w-sDpJWv8kBfs.jpg',
            'https://template.canva.com/EADaoQsTP4M/1/0/400w-1o1MPaNe2OU.jpg',
            'https://template.canva.com/EADan99okM0/1/0/400w-OkkiskNYOE8.jpg',
            'https://template.canva.com/EADaofhf21Y/3/0/400w-8VSSMQ4rQ78.jpg',
            'https://template.canva.com/EADapBC5PiE/2/0/400w-w6W7DqeSd8Y.jpg',
            'https://template.canva.com/EADaoNv6oqc/1/0/400w-tAKRaW6-HFg.jpg',
            'https://template.canva.com/EADajeknFEU/1/0/400w-gpsnZ7YVctQ.jpg',
            'https://template.canva.com/EADao5TLwR0/1/0/400w-tE_2Z5hHXpI.jpg',
            'https://template.canva.com/EADaolmDOZ0/1/0/400w-pBN-xshwYLQ.jpg',
            'https://template.canva.com/EADao6iE2kQ/2/0/400w-r4CF8cz2GKg.jpg',
            'https://template.canva.com/EADanuIZbc8/1/0/400w-eRvIsVj1IaI.jpg',
            'https://template.canva.com/EADao1NkJ7E/1/0/400w-de8oBDCBL6M.jpg',
            'https://template.canva.com/EADaorfZUks/1/0/400w-rtwUr-cL9Ps.jpg',
            'https://template.canva.com/EADaoePs7wk/1/0/400w-pSD-5Lcoebc.jpg',
            'https://template.canva.com/EADanzkw9kg/2/0/400w-lLgpaABPt9Q.jpg',
            'https://template.canva.com/EADajomiw98/1/0/400w-o8vm_tVM13c.jpg',
            'https://template.canva.com/EADaoWfc0Vc/2/0/400w-L2Mmyfjy0YE.jpg',
            'https://template.canva.com/EADapNRuSYA/2/0/400w-Up5t2gb0kO4.jpg',
            'https://template.canva.com/EADaiRMSWPA/2/0/400w-HbDPRIdgG3A.jpg',
            'https://template.canva.com/EADaofJCIlw/1/0/400w-ZNikpRkbdXk.jpg',
            'https://template.canva.com/EADapDv0ToY/2/0/400w-DWg4QF0kThQ.jpg',
            'https://template.canva.com/EADaoX4SxBY/1/0/400w-nuqEQNZeemE.jpg',
            'https://template.canva.com/EADaoRjL_V4/2/0/400w-pA-9ev7DYQU.jpg',
            'https://template.canva.com/EADao5F3NJU/2/0/400w-GDsM5TxR4yc.jpg',
            'https://template.canva.com/EADaiQeUy2c/1/0/400w-E5aoFiLqg2A.jpg',
            'https://template.canva.com/EADapBmglDw/2/0/400w-WMsJRNbSzyY.jpg',
            'https://template.canva.com/EADaokaA5SI/1/0/400w-yBgg1WtR854.jpg',
            'https://template.canva.com/EADapD27ALA/2/0/400w-Gd20jA1lzsQ.jpg',
            'https://template.canva.com/EADah_m90wg/3/0/400w-lezyqE-DViY.jpg',
            'https://template.canva.com/EADaonT9LlE/1/0/400w-W4YirD6I3bo.jpg',
            'https://template.canva.com/EADan_HUHTA/1/0/400w-4SsC3m93j_0.jpg',
            'https://template.canva.com/EADaoq5Be-Y/2/0/400w-5V1LnxsHqEc.jpg',
            'https://template.canva.com/EADajgmds0o/1/0/400w-QXluH3uLobM.jpg',
            'https://template.canva.com/EADan46_03U/1/0/400w-B5zVsm_hLNo.jpg',
            'https://template.canva.com/EADao0wYpqk/2/0/400w-UPUBed_J6RE.jpg',
            'https://template.canva.com/EADao1y8qLw/1/0/400w-DeLy95rdkzA.jpg',
            'https://template.canva.com/EADapCtusRs/1/0/400w-p3Ub5bq9zks.jpg',
            'https://template.canva.com/EADapCISpiE/1/0/400w-QAD-HCsksvI.jpg',
            'https://template.canva.com/EADaonnxDRM/1/0/400w-a_t7tl7fbcg.jpg',
            'https://template.canva.com/EADajr5H-ZA/2/0/400w-m-quIpjwaYI.jpg',
            'https://template.canva.com/EADanl-aOSU/1/0/400w-WROKtsZrZwU.jpg',
            'https://template.canva.com/EADapAOCTH0/1/0/400w-sRYbY3oGU_0.jpg',
            'https://template.canva.com/EADapKaBdi0/2/0/400w-4nVyyWc-Dmw.jpg',
            'https://template.canva.com/EADapOOVuzI/2/0/400w-L1CP27E_c5U.jpg',
            'https://template.canva.com/EADao_xzqg0/2/0/400w-oJTxj85ZplA.jpg',
            'https://template.canva.com/EADajnr62Os/1/0/400w-dnoddcfFZs8.jpg',
            'https://template.canva.com/EADan3LYRwE/1/0/400w-nDaTKD0RWN4.jpg',
            'https://template.canva.com/EADan6LQHqE/1/0/400w-Sc5p3skJ3W0.jpg',
            'https://template.canva.com/EADaoRVomgk/2/0/400w-GRgJX1GswhE.jpg',
            'https://template.canva.com/EADajv9oIVs/1/0/400w-HaJdL6ROwM4.jpg',
            'https://template.canva.com/EADaoaG8qBM/2/0/400w-fT5BmGv53-U.jpg',
            'https://template.canva.com/EADaoMJjXWg/2/0/400w-orlAA0yjK4w.jpg',
            'https://template.canva.com/EADaoji1smo/1/0/400w-fdOUFUFn4f8.jpg',
            'https://template.canva.com/EADaiAJeazA/1/0/400w-i0vtrv3Oq4s.jpg',
            'https://template.canva.com/EADaomL0aYw/1/0/400w-tFdPwgKXjBg.jpg',
            'https://template.canva.com/EADaoTHi2IM/1/0/400w-m35Tocfy41M.jpg',
            'https://template.canva.com/EADaoSvyAmU/1/0/400w-BIxfPIJ6YRI.jpg',
            'https://template.canva.com/EADaiSGN9s0/2/0/400w-JOcWZGmyXFU.jpg',
            'https://template.canva.com/EADapO5enOQ/1/0/400w-NxfBWjYBRBE.jpg',
            'https://template.canva.com/EADao595ucQ/1/0/400w-X0Yl-cuFgS4.jpg',
            'https://template.canva.com/EAEOf7_oofY/1/0/400w-gJxFB21EVB8.jpg',
            'https://template.canva.com/EADapDVNfV8/2/0/400w-yxRrp0NvtT4.jpg',
            'https://template.canva.com/EADanjhPrf0/1/0/400w-LAWnzIrM-Hk.jpg',
            'https://template.canva.com/EADapEdB9b4/1/0/400w-ZOODuDLzAss.jpg',
            'https://template.canva.com/EADakIDnyIM/1/0/400w-qiPlCABiSPw.jpg',
            'https://template.canva.com/EADaoQO10Po/2/0/400w-nllvIBnJm4M.jpg',
            'https://template.canva.com/EADaj75sviE/1/0/400w-j04CSi5f3xw.jpg',
            'https://template.canva.com/EADapJf-vz0/2/0/400w-yEX5u1QMJcc.jpg',
            'https://template.canva.com/EADapI-Z7fE/1/0/400w-L1m7-RRhhh4.jpg',
            'https://template.canva.com/EAD3_Ia3ktM/2/0/400w-qxyKrkblEsA.jpg',
            'https://template.canva.com/EADajUfl6D0/3/0/400w-LKmlkUXT7NM.jpg',
            'https://template.canva.com/EADaoDRc3rg/2/0/400w-MWO6y97_65Q.jpg',
            'https://template.canva.com/EADao2qsPVE/1/0/400w-NlSD4vQiSi8.jpg',
            'https://template.canva.com/EAEOf3HyDME/1/0/400w-ePlbxNXuscU.jpg',
            'https://template.canva.com/EADaoon4CKw/2/0/400w-un7Hl_96gjo.jpg',
            'https://template.canva.com/EADaohBs808/2/0/400w-azIXGTzg8J8.jpg',
            'https://template.canva.com/EADan9rD5Hc/1/0/400w-kKTRp3dhgAc.jpg',
            'https://template.canva.com/EADajqg37lY/1/0/400w-HSsUPvgKSMs.jpg',
            'https://template.canva.com/EADao7hI7os/1/0/400w-AkdTN9iW4vA.jpg',
            'https://template.canva.com/EADaoabmqbQ/1/0/400w-uBhdix7RAYg.jpg',
            'https://template.canva.com/EADaoIXtQ54/1/0/400w-p3gnYXfMOaM.jpg',
            'https://template.canva.com/EADajhjPJj8/1/0/400w-lRkMGxI4nEY.jpg',
            'https://template.canva.com/EADaib5AE88/1/0/400w-aM_NekvsiPg.jpg',
            'https://template.canva.com/EADaofl0pLo/1/0/400w-Bxd3maj87G8.jpg',
            'https://template.canva.com/EADaowCLPU0/2/0/400w-UFF5bZbhUb4.jpg',
            'https://template.canva.com/EADaj4qZctc/2/0/400w-r9hDpUQ11aE.jpg',
            'https://template.canva.com/EADaocEegkQ/2/0/400w-HJSrP_H5r7A.jpg',
            'https://template.canva.com/EADajzJlJ9U/1/0/400w-2WcsUjGYmsU.jpg',
            'https://template.canva.com/EADaopH47jE/1/0/400w-c7F1Pd5sGHg.jpg',
            'https://template.canva.com/EADaiS76j6o/2/0/400w-nr6g2mm0Z0Y.jpg',
            'https://template.canva.com/EADanrPWl_w/2/0/400w-lITPAkT4H18.jpg',
            'https://template.canva.com/EADaj-RiDvQ/1/0/400w-8XlZEwl91nE.jpg',
            'https://template.canva.com/EADapCPLY8Q/1/0/400w-pr-MCSHrvbU.jpg',
            'https://template.canva.com/EADapHGZyNM/1/0/400w-eFlhd1oR2NA.jpg',
            'https://template.canva.com/EADao6pMVuA/1/0/400w-1DhddrRWx04.jpg',
            'https://template.canva.com/EADaovNdGTE/1/0/400w-xKupyqfsaao.jpg',
            'https://template.canva.com/EADaoVEoRV0/1/0/400w--KoGPERzyyc.jpg',
            'https://template.canva.com/EAEOf4OC-0Q/1/0/400w-V5dRJhhLvIg.jpg',
            'https://template.canva.com/EADaoYtssAM/1/0/400w-0RTT6SOuORw.jpg',
            'https://template.canva.com/EADajxfWYQ0/1/0/400w-1njIwWYlCyE.jpg',
            'https://template.canva.com/EADao_QHmGY/2/0/400w-pwg5yOCqbeA.jpg',
            'https://template.canva.com/EADaon6zcMs/2/0/400w-_RLfWGCfliM.jpg',
            'https://template.canva.com/EADaoFz9NVk/1/0/400w-QsP2IjXXspE.jpg',
            'https://template.canva.com/EADapB-wf7Q/2/0/400w-ZH0rLUpkFUo.jpg',
            'https://template.canva.com/EADajjdR8Dg/2/0/400w-vKBxEf7rno0.jpg',
            'https://template.canva.com/EADan3yGD1M/1/0/400w-wn8aLI0yJo4.jpg',
            'https://template.canva.com/EADao4G4rpE/2/0/400w-6oFcgoKaxmg.jpg',
            'https://template.canva.com/EAEOfzODVE4/1/0/400w-Lo4Y57B6tNc.jpg',
            'https://template.canva.com/EADapPg-r9c/1/0/400w-yWippJxAkAI.jpg',
            'https://template.canva.com/EADaogmROhw/1/0/400w-Ju_ay2Mzb48.jpg',
            'https://template.canva.com/EAEOfytWsM4/1/0/400w-UFPpFLsqYvA.jpg',
            'https://template.canva.com/EAD3-hL-9D4/2/0/400w-Mj45m1Pqi2g.jpg',
            'https://template.canva.com/EADapG6-ny8/2/0/400w-hq5zJ5IHypM.jpg',
            'https://template.canva.com/EADao0kHzTo/1/0/400w-dv6JGCx3scs.jpg',
            'https://template.canva.com/EADaoxLwrvE/1/0/400w-RL0Erefm4_I.jpg',
            'https://template.canva.com/EADaos-AKEw/1/0/400w-ZF0KCfS-bm0.jpg',
            'https://template.canva.com/EADaowzTrys/1/0/400w-tVxeMrNhNeg.jpg',
            'https://template.canva.com/EADaoWLabDc/3/0/400w-KU23LdTFQ3w.jpg',
            'https://template.canva.com/EADapKosmLQ/2/0/400w-4kwbK-sV51c.jpg',
            'https://template.canva.com/EADapG-OG8A/1/0/400w-s6NcNYPUGGs.jpg',
            'https://template.canva.com/EADaogriTLY/1/0/400w-xmxMPGYf1E4.jpg',
            'https://template.canva.com/EAEOf4S37x8/1/0/400w-C6f_LnITnzs.jpg',
            'https://template.canva.com/EADan8TYbM0/1/0/400w-EqrpV__4RLk.jpg',
            'https://template.canva.com/EADaopbFc74/1/0/400w-NHFNewtNolA.jpg',
            'https://template.canva.com/EADapJcFMFk/2/0/400w-5stCtf0j0AE.jpg',
            'https://template.canva.com/EADaozxdwEM/2/0/400w-Cs3FU0soU6M.jpg',
            'https://template.canva.com/EADajcETJAg/1/0/400w-hmu1g7mTV9A.jpg',
            'https://template.canva.com/EAEOf46Qyeg/1/0/400w-RzEVfWJfMWk.jpg',
            'https://template.canva.com/EADaorZmGws/1/0/400w-vr0mkIXySTo.jpg',
            'https://template.canva.com/EADanu7JCsY/1/0/400w-WCfaio0B6xI.jpg',
            'https://template.canva.com/EAEOf7jppF8/1/0/400w-uhfQc_kiVe0.jpg',
            'https://template.canva.com/EADapCO-n-k/2/0/400w-zIE5wfnkkXs.jpg',
            'https://template.canva.com/EADaoleMoEw/2/0/400w-UqWwpfRWjKg.jpg',
            'https://template.canva.com/EADaosk19Z4/1/0/400w-CGFVapwIAxw.jpg',
            'https://template.canva.com/EADan56HqdQ/1/0/400w-hz2XKGRB6Pg.jpg',
            'https://template.canva.com/EADajoNHq0g/1/0/400w-GA0ln7nhFKY.jpg',
            'https://template.canva.com/EADajYdDVlw/1/0/400w-YY__T8iRRq0.jpg',
            'https://template.canva.com/EADaok-_R94/1/0/400w-0l9rgDjb440.jpg',
            'https://template.canva.com/EAEOfz-pOQo/1/0/400w-hsD3wEWtZFM.jpg',
            'https://template.canva.com/EADaozb_60I/1/0/400w-Q4NkJDmGL1M.jpg',
            'https://template.canva.com/EADaozXpt94/2/0/400w-MkzcUg6LSR0.jpg',
            'https://template.canva.com/EADao0f29qI/1/0/400w-yprI44qQpbo.jpg',
            'https://template.canva.com/EADapAIIexM/1/0/400w-H47wktzM2Y0.jpg',
            'https://template.canva.com/EADaoCxKRxY/1/0/400w-XA50UgmrRDw.jpg',
            'https://template.canva.com/EADaoZC3v0c/1/0/400w-suhKWAe51jE.jpg',
            'https://template.canva.com/EADaiGyMXTo/2/0/400w-fEp44PTLSYo.jpg',
            'https://template.canva.com/EADaonIOcNo/1/0/400w-b2Kf7K7mzmA.jpg',
            'https://template.canva.com/EADapPMLoKU/1/0/400w-2vqF401PfBk.jpg',
            'https://template.canva.com/EADaiazM5Po/1/0/400w-ZejRM_ZnotM.jpg',
            'https://template.canva.com/EADaimCPqdY/1/0/400w-df47_8zae_o.jpg',
            'https://template.canva.com/EADaovbdPrw/2/0/400w-hH62Xm5UcWs.jpg',
            'https://template.canva.com/EADaobxvTlA/1/0/400w-CKolG3N1lAM.jpg',
            'https://template.canva.com/EADan_MNlPQ/1/0/400w-s9mVxPe4fE4.jpg',
            'https://template.canva.com/EADao6v2cSA/1/0/400w-sPzDZ9jTbR4.jpg',
            'https://template.canva.com/EADajgcMN7c/1/0/400w-vBz4auQQf_A.jpg',
            'https://template.canva.com/EADajntIIc0/1/0/400w-b2Kf7K7mzmA.jpg',
            'https://template.canva.com/EADaoqlLPGM/3/0/400w-Ct1gSKKN-7w.jpg',
            'https://template.canva.com/EADao-2e0_U/1/0/400w-FxUAtBeUGWo.jpg',
            'https://template.canva.com/EAEOf8qj660/1/0/400w-6qv5dVtCERY.jpg',
            'https://template.canva.com/EADao3TRN6E/3/0/400w-T_Gdy7pJ6VQ.jpg',
            'https://template.canva.com/EADao8nEX5Q/1/0/400w-TkgVhMaFp8k.jpg',
            'https://template.canva.com/EADaj40y3-Y/2/0/400w--41WoBoETdo.jpg',
            'https://template.canva.com/EAD3_Zb2X68/2/0/400w-YkWFySEvky8.jpg',
            'https://template.canva.com/EADaoIw1Ok0/2/0/400w-gUhFd1mHV9A.jpg',
            'https://template.canva.com/EADaiSwJaHo/1/0/400w-r3wFa47uXsw.jpg',
            'https://template.canva.com/EADapOcRF4I/2/0/400w-8gLWYgH3Fg0.jpg',
            'https://template.canva.com/EADakJ8VVC8/1/0/400w-ciEbP2pCRCM.jpg',
            'https://template.canva.com/EADan-eI7Oo/1/0/400w-tX8BtbMLrf4.jpg',
            'https://template.canva.com/EADaji8ZmOg/1/0/400w-_YW9bwx9z8w.jpg',
            'https://template.canva.com/EADaod6wdtY/1/0/400w-t9dCSW5RAg4.jpg',
            'https://template.canva.com/EADaonzxd1c/1/0/400w-XBmaTdteg3s.jpg',
            'https://template.canva.com/EADaosyj9W8/2/0/400w-AcgzWUluK9I.jpg',
            'https://template.canva.com/EADapHEUYYE/1/0/400w--WBYlCWRVAQ.jpg',
            'https://template.canva.com/EADajiO1lhM/2/0/400w-Nsh53ENqBiw.jpg',
            'https://template.canva.com/EADaozgFGNY/2/0/400w-6v69YD3HJc0.jpg',
            'https://template.canva.com/EADao20BGz0/2/0/400w-rQ4gmcADttY.jpg',
            'https://template.canva.com/EADajxlQnOI/1/0/400w-kTR2pyBmHcY.jpg',
            'https://template.canva.com/EADaoQR0w4w/1/0/400w-xK3MXA_z7WM.jpg',
            'https://template.canva.com/EADaiS-FwOQ/1/0/400w-Wo73nyRKx_g.jpg',
            'https://template.canva.com/EADanoMbp5Q/2/0/400w-xlfPdfO205o.jpg',
            'https://template.canva.com/EADah5IDLBs/1/0/400w-X2Mzuopl934.jpg',
            'https://template.canva.com/EADanwpsY6U/1/0/400w-RlUjaL6_4Mo.jpg',
            'https://template.canva.com/EADaoyF1AiQ/1/0/400w-RT3XHeYC5jc.jpg',
            'https://template.canva.com/EADao1DUn5M/1/0/400w-mLqIfB808E0.jpg',
            'https://template.canva.com/EAEOf-j-91I/1/0/400w-ZryIplb2Vz4.jpg',
            'https://template.canva.com/EADao8WELC4/2/0/400w-HcDHG0Sb2Mk.jpg',
            'https://template.canva.com/EADaorTbHkc/2/0/400w-UFmiUtaK69Y.jpg',
            'https://template.canva.com/EADan3VbnjE/1/0/400w-ANdozuWYmWQ.jpg',
            'https://template.canva.com/EADajyTDZR0/1/0/400w-CPLztUkGBAU.jpg',
            'https://template.canva.com/EADajtNr6YM/3/0/400w-NkuYI9FAaT0.jpg',
            'https://template.canva.com/EADapMT7VNk/1/0/400w-07_2fbKA1zw.jpg',
            'https://template.canva.com/EADapJvZ9Ak/1/0/400w-L4NTi092MFk.jpg',
            'https://template.canva.com/EADaoo2MXzM/2/0/400w-r5wHVptxQRc.jpg',
            'https://template.canva.com/EADaoV8CDXA/1/0/400w-KEy8zuISfv8.jpg',
            'https://template.canva.com/EADaoMzVa-U/1/0/400w-0SAht5UJx1U.jpg',
            'https://template.canva.com/EADaoroZ2C0/1/0/400w-R6WvWXMXXGA.jpg',
            'https://template.canva.com/EADaopYBE8M/1/0/400w-fZ44ITnlkMU.jpg',
            'https://template.canva.com/EADaoyrx5sU/1/0/400w-Z-awUeCx6Uo.jpg',
            'https://template.canva.com/EADaiVGv48U/1/0/400w-GL3ADMxXqSU.jpg',
            'https://template.canva.com/EADaovNqApA/1/0/400w-mgTlLrap8ec.jpg',
            'https://template.canva.com/EADao4C7naw/2/0/400w-yaG7TVyp5U0.jpg',
            'https://template.canva.com/EADaj98cWNA/1/0/400w-bM9Zz3Or0vs.jpg',
            'https://template.canva.com/EAEOf13txMA/1/0/400w-9gKfOKlsXXE.jpg',
            'https://template.canva.com/EADaoVCaqZk/1/0/400w-s2UdzmSLvGM.jpg',
            'https://template.canva.com/EADapKr11eM/1/0/400w-LsbXF4BIJwQ.jpg',
            'https://template.canva.com/EADanq45d4Q/2/0/400w-FEpkQlqvQtU.jpg',
            'https://template.canva.com/EADaoygcJcs/1/0/400w-Qq7hTTL9f9M.jpg',
            'https://template.canva.com/EADaozxenWM/1/0/400w-2rgAm1sFkFA.jpg',
            'https://template.canva.com/EADaoKQXLeg/3/0/400w-SPZZpG5c64k.jpg',
            'https://template.canva.com/EADaotDE7qw/2/0/400w-Ms_RtWYmrWA.jpg',
            'https://template.canva.com/EADao4QSbxs/1/0/400w-2X3z6bWqGPs.jpg',
            'https://template.canva.com/EADaoyH7jfY/2/0/400w-rO9g5XHbOVc.jpg',
            'https://template.canva.com/EADaozo4rTs/1/0/400w-K-W93uxPfGc.jpg',
            'https://template.canva.com/EADaiVp_Vx8/1/0/400w-6-1jXF-JHfE.jpg',
            'https://template.canva.com/EADanq_2lTA/1/0/400w-aB07ryNAuAU.jpg',
            'https://template.canva.com/EADao85wQek/1/0/400w-6AroLYAlcxY.jpg',
            'https://template.canva.com/EADanvrUbAM/2/0/400w-0gSLk4__zTQ.jpg',
            'https://template.canva.com/EADano0RQ9A/1/0/400w-D12YW5S5Q4k.jpg',
            'https://template.canva.com/EADaiZxMGu8/1/0/400w-nzADGX1D7jk.jpg',
            'https://template.canva.com/EADakAoC1bg/1/0/400w-w1mn-ToQS4s.jpg',
            'https://template.canva.com/EADaoERkH9U/1/0/400w-dCLnwo3l_As.jpg',
            'https://template.canva.com/EADaiaSH8uk/3/0/400w-kbO4rced3hc.jpg',
            'https://template.canva.com/EADaj8BUdTA/2/0/400w-l_Mp4aQJGfM.jpg',
            'https://template.canva.com/EADapNL_bUY/1/0/400w-Vf9mnIOBhJw.jpg',
            'https://template.canva.com/EADaovCvD3k/2/0/400w-_54dXJMWBLY.jpg',
            'https://template.canva.com/EADaosDZ-1s/1/0/400w-R5e9DAdORkU.jpg',
            'https://template.canva.com/EADaonXwdb0/2/0/400w-2q-Haq-GZvc.jpg',
            'https://template.canva.com/EADaol1U2zM/1/0/400w-eVxUb6UvNdA.jpg',
            'https://template.canva.com/EADaoZel780/1/0/400w-7N0PUMUCADA.jpg',
            'https://template.canva.com/EADapBbzuFY/2/0/400w-kbal_XldgyQ.jpg',
            'https://template.canva.com/EADapObxZNY/2/0/400w-O4MI_2JtwBA.jpg',
            'https://template.canva.com/EADapIcPffo/1/0/400w-DWZDPRJ-2tw.jpg',
            'https://template.canva.com/EADaoSH72WU/1/0/400w-txnCIDi5q-8.jpg',
            'https://template.canva.com/EADaoqUdEtM/1/0/400w-X4DN0EjhSjk.jpg',
            'https://template.canva.com/EADajsKgpgc/1/0/400w-Bk7IqsLiS1E.jpg',
            'https://template.canva.com/EADaia5nwAU/1/0/400w-oPDrhN6JLyc.jpg',
            'https://template.canva.com/EAEOf_WQPGI/1/0/400w-NJVisonieF4.jpg',
            'https://template.canva.com/EADajz6a6yU/2/0/400w-NlTt64zfG80.jpg',
            'https://template.canva.com/EADaoll7wPA/1/0/400w-wmjaQE9VW_Q.jpg',
            'https://template.canva.com/EADaoQZ3Zb4/1/0/400w-DHdn9KlRK0s.jpg',
            'https://template.canva.com/EADaoVjthzE/2/0/400w-TB4qU-GobEg.jpg',
            'https://template.canva.com/EADaouaZALM/1/0/400w-TmQlCqItmAA.jpg',
            'https://template.canva.com/EADaobCKeJY/2/0/400w-zZZx6r1TaTE.jpg',
            'https://template.canva.com/EADaoNMbTOA/1/0/400w-QWBOllxOg_A.jpg',
            'https://template.canva.com/EADaj7wYYEk/2/0/400w-oX7oPtM_wDA.jpg',
            'https://template.canva.com/EADao9Kut74/1/0/400w-DaywggLkIPQ.jpg',
            'https://template.canva.com/EADaokPcgio/1/0/400w-IYi8WdO_7BI.jpg',
            'https://template.canva.com/EADaoGJvfmI/2/0/400w-uI8zEDjtYeQ.jpg',
            'https://template.canva.com/EADaoAYweWE/1/0/400w-o8dWnP4y_cc.jpg',
            'https://template.canva.com/EADaiNoKAL0/2/0/400w-GKFDeXUYRdQ.jpg',
            'https://template.canva.com/EADao4gqTcY/2/0/400w-SICJiD9y8Vs.jpg',
            'https://template.canva.com/EADaopCKYfQ/1/0/400w-rHj-3b1ftNI.jpg',
            'https://template.canva.com/EADapC42jL8/2/0/400w-W0D2Wx1wJQE.jpg',
            'https://template.canva.com/EADaj3s2eQ8/1/0/400w-ITCqXBXLbro.jpg',
            'https://template.canva.com/EADaocG0zOA/2/0/400w-z94uABVgYO8.jpg',
            'https://template.canva.com/EAD_fNbuVHk/1/0/400w-u1ymWNWz9Gc.jpg',
            'https://template.canva.com/EADaozlltPw/2/0/400w-gYSLtYUud54.jpg',
            'https://template.canva.com/EADaiYv5Mlk/2/0/400w-9jaT6FADMKo.jpg',
            'https://template.canva.com/EADaiJvPxKo/2/0/400w-EQmetFbbYK0.jpg',
            'https://template.canva.com/EADaoF6SO04/1/0/400w-4lOp3Auj7Lo.jpg',
            'https://template.canva.com/EADaoSAfJQ0/1/0/400w-9f_fjzT0EDM.jpg',
            'https://template.canva.com/EADan9QzMmc/1/0/400w-6NKyqouC-IM.jpg',
            'https://template.canva.com/EADaoNHx6II/1/0/400w-x5WCXYHZfCQ.jpg',
            'https://template.canva.com/EADaoteMhLw/2/0/400w-WdQ6FM3-zmI.jpg',
            'https://template.canva.com/EADajbevEWQ/3/0/400w-Wv6LiSk2ERc.jpg',
            'https://template.canva.com/EADaoenQZ9Q/1/0/400w-QAidPC23K10.jpg',
            'https://template.canva.com/EADaoq1TiWE/1/0/400w-4sRx2jsdMog.jpg',
            'https://template.canva.com/EADapHvVdJU/1/0/400w-oI-edVWwF5Y.jpg',
            'https://template.canva.com/EADajWTQXQ0/1/0/400w-2fTUiF1_eGo.jpg',
            'https://template.canva.com/EADaoRik0N4/1/0/400w-VJQqqdRUevk.jpg',
            'https://template.canva.com/EADao4iNB80/2/0/400w-yk3PIav5Czw.jpg',
            'https://template.canva.com/EADan_iotqU/1/0/400w-pvr-VK0CHWk.jpg',
            'https://template.canva.com/EAEOfxB75us/1/0/400w-wbUeAQjN3co.jpg',
            'https://template.canva.com/EADaoBbS9FM/1/0/400w-H60WFJhQtik.jpg',
            'https://template.canva.com/EADaninu64k/1/0/400w-owrYoYEIX9Y.jpg',
            'https://template.canva.com/EADaoEQfB7E/2/0/400w-upZ1mJK4UDM.jpg',
            'https://template.canva.com/EADao4VEDqo/2/0/400w-6JbklOmNMh4.jpg',
            'https://template.canva.com/EADajxCBA8I/1/0/400w-l2xROJ4Mugw.jpg',
            'https://template.canva.com/EADaovqoW08/1/0/400w-hdZ781XNyPo.jpg',
            'https://template.canva.com/EADaiJp_gkQ/2/0/400w-y0YXDB7qIos.jpg',
            'https://template.canva.com/EADaiCiKT-o/1/0/400w-pTBJUj2gSvU.jpg',
            'https://template.canva.com/EADaoQhKkh0/1/0/400w-ooBHMzkGd00.jpg',
            'https://template.canva.com/EADan3rXG-0/2/0/400w-VDAHlwBmzZQ.jpg',
            'https://template.canva.com/EADaoBqcEDY/1/0/400w-GQcp-cYJnK8.jpg',
            'https://template.canva.com/EADann1e-Ws/2/0/400w-t_eHKGnYilw.jpg',
            'https://template.canva.com/EADaoJGNqjM/1/0/400w-9qJc3pKxxXY.jpg',
            'https://template.canva.com/EADaoFlbbFo/2/0/400w-bP9JO1J38ZE.jpg',
            'https://template.canva.com/EADaj1YHgJ4/1/0/400w-a8dy1IA2WY0.jpg',
            'https://template.canva.com/EADanvTaWzg/1/0/400w-eVkL3nGOYfg.jpg',
            'https://template.canva.com/EADaomKylzw/1/0/400w-pVzj-2OVbNs.jpg',
            'https://template.canva.com/EAEOf8LPL1g/1/0/400w-bIrEmMJIEBA.jpg',
            'https://template.canva.com/EADapFdXroI/1/0/400w-qSdOgGW3RVw.jpg',
            'https://template.canva.com/EADao6wbwLk/1/0/400w-DGlAIW2a04c.jpg',
            'https://template.canva.com/EADao089A6w/1/0/400w-1-Ygk8CoeB4.jpg',
            'https://template.canva.com/EAEOfxahntU/1/0/400w-CRFEIhYYagk.jpg',
            'https://template.canva.com/EADao1k-DA0/2/0/400w-bilAAqfl5Sw.jpg',
            'https://template.canva.com/EADaoHzIrLc/1/0/400w-PIvfAkhgekg.jpg',
            'https://template.canva.com/EADajaelus8/2/0/400w-DfD8Kh_tHIw.jpg',
            'https://template.canva.com/EADaiYSIXT8/2/0/400w-xU5DT-MC9Mg.jpg',
            'https://template.canva.com/EADao3SL2jg/1/0/400w-UkX_Nv5qg0g.jpg',
            'https://template.canva.com/EADaifsFIgQ/2/0/400w-XyvjF9nqCsc.jpg',
            'https://template.canva.com/EADaig0GMAw/1/0/400w-vcflmhsFm34.jpg',
            'https://template.canva.com/EADapORYGso/1/0/400w-AxAS-3MDmvw.jpg',
            'https://template.canva.com/EADapAzido0/2/0/400w-i4vzi4LPO0I.jpg',
            'https://template.canva.com/EADan60TR3I/1/0/400w-FB7F9wQXHIo.jpg',
            'https://template.canva.com/EADaojURcio/1/0/400w-ce8AzISAwrM.jpg',
            'https://template.canva.com/EADaoiQGn_c/1/0/400w-LQkovHIUfOQ.jpg',
            'https://template.canva.com/EADaoz2E0Fc/1/0/400w-ExWmmyFRNR4.jpg',
            'https://template.canva.com/EADaiEG7ijM/1/0/400w-kFJj0bMDKiI.jpg',
            'https://template.canva.com/EADaogjNwF0/2/0/400w-pAZjkzWt41M.jpg',
            'https://template.canva.com/EAEOf8NoaBc/1/0/400w-GpNW0oUDW54.jpg'
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
