<!-- footer-->
<div class="footer" style="background-image:url({{ asset('assets/img/adn/bg-msh-miring.png') }});-webkit-background-size: auto;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center middle;background-origin: content-box;">
    <div class="row no-gutters justify-content-center">
        @php
            $array = [
                ['url'=>'/','icon'=>'home','text'=>'Home'],
                ['url'=>'/','icon'=>'insert_chart_outline','text'=>'Analytics'],
                ['url'=>'/','icon'=>'account_balance_wallet','text'=>'Wallet'],
                ['url'=>'/','icon'=>'shopping_bag','text'=>'Keranjang'],
                ['url'=>'/','icon'=>'account_circle','text'=>'Profil'],
            ];
            $no = 0;
            foreach($array as $key=>$val)
            {
                echo '<div class="col-auto '.(($no=='0')?'active':'').'">';
                echo '<a href="'.$val['url'].'" class="">';
                echo '<i class="material-icons">'.$val['icon'].'</i>';
                echo '<p>'.$val['text'].'</p>';
                echo '</a>';
                echo '</div>';
                $no++;
            }
        @endphp
    </div>
</div>
