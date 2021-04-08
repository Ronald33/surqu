var app = angular.module('app', ['googlechart']);

angular.module('app').controller('ChartController', chartController);

chartController.$inject = ['$http', '$interval'];
function chartController($http, $interval)
{
    'use strict';

    var api = 'http://localhost/surqu/api/';
    var vm = this;
    var last_id = 0;
    var presion = 0, humedad = 0, temperatura = 0, temperaturaInterna = 0;

    vm.gauge = 
    {
        type: 'Gauge', 
        options: 
        {
            width: 400,
            height: 120,
            redFrom: 90,
            redTo: 100,
            yellowFrom: 75,
            yellowTo: 90,
            minorTicks: 5
        }, 
        data: 
        [
            ['Label', 'Value'], 
            ['Presión', presion], 
            ['Humedad', humedad], 
            ['Temperatura', temperatura], 
            ['Temp. Interna', temperaturaInterna]
        ]
    };

    vm.template = 
    {
        type: 'AnnotationChart', 
        options: { displayAnnotations: true }, 
        data: 
        {
            rows: [], 
            cols: 
            [
                {label: "Fecha", type: "date"},
                {label: "Valor", type: "number"}
            ]
        }, 
    };

    vm.presion = angular.copy(vm.template);
    vm.humedad = angular.copy(vm.template);
    vm.temperatura = angular.copy(vm.template);
    vm.temperaturaInterna = angular.copy(vm.template);

    function _updateData()
    {
        $http.get(api + 'Dato', { params: {id: last_id} }).then(function(response)
        {
            if(response.data.length > 0)
            {
                var last = response.data[response.data.length - 1];
                
                last_id = last.id;
                vm.gauge.data[1][1] = last.presion;
                // presion = last.presion;
                humedad = last.humedad;
                temperatura = last.temperatura;
                temperaturaInterna = last.temperaturaInterna;

                console.log('gauge');
                console.log(vm.gauge.data[1]);

                angular.forEach(response.data, function(value)
                {
                    vm.presion.data.rows.push(
                    {
                        c:  [{v: new Date(value.fecha)}, {v: value.presion}]
                    });

                    vm.humedad.data.rows.push(
                    {
                        c:  [{v: new Date(value.fecha)}, {v: value.humedad}]
                    });

                    vm.temperatura.data.rows.push(
                    {
                        c:  [{v: new Date(value.fecha)}, {v: value.temperatura}]
                    });

                    vm.temperaturaInterna.data.rows.push(
                    {
                        c:  [{v: new Date(value.fecha)}, {v: value.temperaturaInterna}]
                    });
                });
            }
        });
    }

    _updateData();
    $interval(_updateData, 5000);
}