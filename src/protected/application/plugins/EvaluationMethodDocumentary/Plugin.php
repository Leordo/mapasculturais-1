<?php
namespace EvaluationMethodDocumentary;

use MapasCulturais\i;
use MapasCulturais\App;
use MapasCulturais\Entities;

const STATUS_INVALID = 'invalid';
const STATUS_VALID = 'valid';

class Plugin extends \MapasCulturais\EvaluationMethod {
    

    public function getSlug() {
        return 'documentary';
    }

    public function getName() {
        return i::__('Avaliação Documental');
    }

    public function getDescription() {
        return i::__('Consiste num checkbox e um textarea para cada campo do formulário de inscrição.');
    }

    public function getConfigurationFormPartName() {
        return ;
    }

    protected function _register() {
        ;
    }

    function enqueueScriptsAndStyles() {
        $app = App::i();

        $app->view->enqueueScript('app', 'documentary-evaluation-form', 'js/evaluation-form--documentary.js', ['entity.module.opportunity']);
        $app->view->enqueueStyle('app', 'documentary-evaluation-method', 'css/documentary-evaluation-method.css');
    }

    public function _init() {
        $app = App::i();
        $app->hook('evaluationsReport(documentary).sections', function(Entities\Opportunity $opportunity, &$sections) use($app) {
            $columns = [];
            $evaluations = $opportunity->getEvaluations();

            foreach($evaluations as $eva){
                $evaluation = $eva['evaluation'];
                $data = (array) $evaluation->evaluationData;
                foreach($data as $id => $d){
                    $columns[$id] = $d['label'];
                }
            }

            $result = [
                'registration' => $sections['registration'],
                'committee' => $sections['committee'],
            ];


            foreach($columns as $id => $col){
                $result[$id] = (object) [
                    'label' => $col,
                    'color' => '#EEEEEE',
                    'columns' => [
                        'val' => (object) [
                            'label' => i::__('Avaliação'),
                            'getValue' => function(Entities\RegistrationEvaluation $evaluation) use($id) {
                                $evaluation_data = (array) $evaluation->evaluationData;

                                if(isset($evaluation_data[$id])){
                                     $data = $evaluation_data[$id];

                                     if($data['evaluation'] == 'valid'){
                                         return i::__('Válida');
                                     } else if($data['evaluation'] == 'invalid') {
                                         return i::__('Inválida');
                                     } else {
                                         return '';
                                     }
                                } else {
                                    return '';
                                }
                            }
                        ],
                        'obs' => (object) [
                            'label' => i::__('Observações'),
                            'getValue' => function(Entities\RegistrationEvaluation $evaluation) use($id) {
                                
                                $evaluation_data = (array) $evaluation->evaluationData;
                                if (isset($evaluation_data[$id])) {
                                    $data = $evaluation_data[$id];
                                    return $data['obs'];
                                } else {
                                    return '';
                                }
                            }
                        ],
                    ]
                ];
            }

            $result['evaluation'] = $sections['evaluation'];

            $sections = $result;
        });
    }

    public function _getConsolidatedResult(Entities\Registration $registration) {
        $app = App::i();

        $evaluations = $app->repo('RegistrationEvaluation')->findBy(['registration' => $registration]);

        if(count($evaluations) === 0){
            return 0;
        }

        $result = 1;

        foreach ($evaluations as $eval){
            if($eval->status === \MapasCulturais\Entities\RegistrationEvaluation::STATUS_DRAFT){
                return 0;
            }

            $result = ($result === 1 && $this->getEvaluationResult($eval) === 1) ? 1 : -1;
        }

        return $result;
    }

    public function getEvaluationResult(Entities\RegistrationEvaluation $evaluation) {
        $data = (array) $evaluation->evaluationData;
        
        if(count($data) == 0){
            return 1; // valid
        }

        foreach ($data as $id => $value) {
            if(isset($value['evaluation']) && $value['evaluation'] === STATUS_INVALID){
                return -1;
            }
        }

        return 1;
    }

    public function valueToString($value) {

        if($value === 1){
            return i::__('Inscrição válida');
        } else if($value === -1){
            return i::__('Inscrição inválida');
        }

        return '';

    }
    
    public function fetchRegistrations() {
        return true;
    }

}