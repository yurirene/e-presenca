<?php $this->layout('_template'); ?>

<div class="row">

    <div class="col-md-6 offset-md-3 col-sm-12">
        <h2 class="text-center">Lista de Presença</h2>

        <table width='100%'>


            <?php
            foreach($lista['chamada'] as $l):
            ?>
            <tr>
                <th colspan="2" class="text-center text-white negro" ><?=$l['Sessao']?></th>
            </tr>
            <?php
                foreach($l['Dados'] as $i):
            ?>
            <tr>
                <th colspan="2" class="cinza"><?=$i['Igreja']?></th>
            </tr>
            <?php 
                        foreach($i['Delegados'] as $d):
                            $status = "<span class='badge badge-success'>Presente</span>";
                            if($d['presenca']==0){
                                $status = "<span class='badge badge-danger'>Ausente</span>";
                            }
            ?>

            <tr>
                <td><?=$d['nome']?></td>
                <td><?=$status?></td>
            </tr>
            <?php 
                    endforeach;
                endforeach;
            endforeach;
            ?>

        </table>

    </div>
</div>