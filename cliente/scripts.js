var app = angular.module('app', ['googlechart', 'daterangepicker', 'ui.bootstrap']);

angular.module('app').controller('ChartController', chartController);

chartController.$inject = ['$http', '$interval', '$window'];
function chartController($http, $interval, $window)
{
    'use strict';

    var vm = this;

    var api = 'http://localhost/surqu/api/';
    var last_id = 0;

    /* Descarga */
    vm.descargar = descargar;

    vm.daterangepicker_options = 
    {
        startDate: moment().subtract(29, 'days'), 
        endDate: moment(), 
        showDropdowns: true, 
        minYear: 2018, 
        maxYear: parseInt(moment().format('YYYY'),10) + 1, 
        timePicker: true, 
        alwaysShowCalendars: true, 
        locale: 
        {
            applyLabel: "Aceptar",
            format: "DD/MM/YY HH:mm A",
            cancelLabel: 'Cancelar',
            customRangeLabel: 'Rango personalizado'
        },
        ranges: 
        {
            'Ayer': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
            'Hoy': [moment().startOf('day'), moment().endOf('day')],
            'Semana actual': [moment().startOf('week').startOf('day'), moment().endOf('day')], 
            'Semana anterior': [moment().subtract(1, 'week').startOf('week').startOf('day'), moment().subtract(1, 'week').endOf('week').endOf('day')], 
            'Mes actual': [moment().startOf('month').startOf('day'), moment().endOf('day')], 
            'Mes anterior': [moment().subtract(1, 'month').startOf('month').startOf('day'), moment().subtract(1, 'month').endOf('month').endOf('day')], 
            'Últimos 7 días': [moment().subtract(7, 'days').startOf('day'), moment().endOf('day')],
            'Últimos 30 días': [moment().subtract(30, 'days').startOf('day'), moment().endOf('day')]
        }
    };

    vm.descarga = 
    {
        fecha: 
        {
            startDate: moment().startOf('day'), 
            endDate: moment().endOf('day')
        }, 
        selecteds: 
        {
            presion: true, 
            humedad: true, 
            temperatura: true, 
            temperaturaInterna: true
        }, 
    }

    function descargar()
    {
        var inicio = vm.descarga.fecha.startDate.unix(), fin = vm.descarga.fecha.endDate.unix(), selecteds = [];
        angular.forEach(vm.descarga.selecteds, function(value, key) { if(value) { selecteds.push(key); } });
        $window.location.href = api + '/Dato?inicio=' + inicio + '&fin=' + fin+'&seleccionados=' + selecteds.join();
    }
    /* Fin de Descarga */

    /* Gauge */
    function _getTemplateGauge(label)
    {
        return {
            type: 'Gauge', 
            options: 
            {
                redFrom: 90,
                redTo: 100,
                yellowFrom: 75,
                yellowTo: 90,
                minorTicks: 5, 
            }, 
            data: 
            [
                ['Label', 'Value'], 
                [label, 0]
            ]
        };
    }

    vm.presion_gauge = _getTemplateGauge('Presión');
    vm.humedad_gauge = _getTemplateGauge('Humedad');
    vm.temperatura_gauge = _getTemplateGauge('Temperatura');
    vm.temperaturaInterna_gauge = _getTemplateGauge('Temperatura Interna');
    /* Fin de Gauge */

    /* Lineal */
    function _getTemplateLineal()
    {
        return {
            type: 'AnnotationChart', 
            options: 
            {
                dateFormat: 'dd/MM/YY HH:mm:ss', 
                displayAnnotations: true, 
                displayAnnotationsFilter: true, 
                // displayZoomButtons: false
            }, 
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
    }

    vm.presion_lineal = _getTemplateLineal();
    vm.humedad_lineal = _getTemplateLineal();
    vm.temperatura_lineal = _getTemplateLineal();
    vm.temperaturaInterna_lineal = _getTemplateLineal();
    /* Fin de Lineal */

    /* Alimentacion */
    function _updateData()
    {
        $http.get(api + '/Dato', { params: {id: last_id} }).then(function(response)
        {
            if(response.data.length > 0)
            {
                var last = response.data[response.data.length - 1];
                last_id = last.id;
                vm.presion_gauge.data[1][1] = last.presion;
                vm.humedad_gauge.data[1][1] = last.humedad;
                vm.temperatura_gauge.data[1][1] = last.temperatura;
                vm.temperaturaInterna_gauge.data[1][1] = last.temperaturaInterna;

                angular.forEach(response.data, function(value)
                {
                    var fecha = new Date(value.fecha * 1000);
                    vm.presion_lineal.data.rows.push({c:  [{v: fecha}, {v: value.presion}]});
                    vm.humedad_lineal.data.rows.push({c:  [{v: fecha}, {v: value.humedad}]});
                    vm.temperatura_lineal.data.rows.push({c:  [{v: fecha}, {v: value.temperatura}]});
                    vm.temperaturaInterna_lineal.data.rows.push({c:  [{v: fecha}, {v: value.temperaturaInterna}]});
                });

                _recortarData();
            }
        });
    }

    function _recortarData()
    {
        var max_size = 1000;
        vm.presion_lineal.data.rows = vm.presion_lineal.data.rows.splice(vm.presion_lineal.data.rows.length - max_size, max_size);
        vm.humedad_lineal.data.rows = vm.humedad_lineal.data.rows.splice(vm.humedad_lineal.data.rows.length - max_size, max_size);
        vm.temperatura_lineal.data.rows = vm.temperatura_lineal.data.rows.splice(vm.temperatura_lineal.data.rows.length - max_size, max_size);
        vm.temperaturaInterna_lineal.data.rows = vm.temperaturaInterna_lineal.data.rows.splice(vm.temperaturaInterna_lineal.data.rows.length - max_size, max_size);
    }

    _updateData();
    $interval(_updateData, 5000);
    /* Fin de Alimentacion */
}