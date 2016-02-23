<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Template\Backoffice;

/**
 * Description of Add_Groupe
 *
 * @author CDB
 */
class Add_Groupe extends Base {

    public function buildBody() {
        parent::buildBody();
        ?>
        <h1>Ajout de personne</h1>
        <div class="panel panel-defau&lt">
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="personne" class="col-sm-2 control-label">Personne à ajouter</label>
                        <div class="col-sm-10">
                            <input type="text" id="personne" name="personne" class="form-control" value="<?php echo $this->truc ?>"data-toggle="tooltip" data-placement="right" title="Chercher la personne par son nom ou son trigramme"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Groupe" class="col-sm-2 control-label">Groupe</label>
                        <div class="col-sm-10">
                            <div class="btn-group">
                                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Groupe <span class="caret"></span></button>
                                <ul class="dropdown-menu"><li>un test</li></ul>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                test
                            </th>
                            <th>
                                test
                            </th>
                            <th>
                                test
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" name=""/>
                            </td>
                            <td>
                                <input type="checkbox" name=""/>
                            </td>
                            <td>
                                <input type="checkbox" name=""/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

}
