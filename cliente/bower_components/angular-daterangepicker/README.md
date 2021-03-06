# Date Range Picker for Angular and Bootstrap
![Dependencies](https://david-dm.org/fragaria/angular-daterangepicker.png)

Angular.js directive for Dan Grossmans's [Bootstrap Datepicker](https://github.com/dangrossman/bootstrap-daterangepicker).

## Maintainer needed!
Hello, as you may noticed, we have troubles maintaining this repo. So if there is somebody willing to help merging PRs, testing and releasing, please contact me at lukas.marek(at)fragaria.cz.
Thank you!

[DEMO](http://fragaria.github.io/angular-daterangepicker/)

**Beware: Use [Bootstrap Datepicker](https://github.com/dangrossman/bootstrap-daterangepicker) v 3.0.3 and newer!**

![Date Range Picker screenshot](http://i.imgur.com/zDjBqiS.png)

## Installation via Bower
The easiest way to install the picker is:
```
bower install angular-daterangepicker --save
```
## Manual installation
This directive depends on [Bootstrap Datepicker](https://github.com/dangrossman/bootstrap-daterangepicker), [Bootstrap](http://getbootstrap.com), [Moment.js](http://momentjs.com/) and [jQuery](http://jquery.com/).
Download dependencies above and then use [minified](js/angular-daterangepicker.min.js) or [normal](angular-daterangepicker.js) version.

## Basic usage
Assuming that bower installation directory is `bower_components`. In case of other installation directory, please update paths accordingly.

```
<script src="bower_components/jquery/jquery.js"></script>
<script src="bower_components/angular/angular.js"></script>
<script src="bower_components/momentjs/moment.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="bower_components/angular-daterangepicker/js/angular-daterangepicker.js"></script>

<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css"/>
```

Declare dependency:

```
App = angular.module('app', ['daterangepicker']);
```

Prepare model in your controller. The model **must** have `startDate` and `endDate` attributes:

```
exampleApp.controller('TestCtrl', function ($scope) {
	$scope.datePicker = { date: {startDate: null, endDate: null} };
}
```


Then in your HTML just add attribute `date-range-picker` to any input and bind it to model.

```
<div ng-controller="TestCtrl">
<input date-range-picker class="form-control date-picker" type="text" ng-model="datePicker.date" />
</div>
```

See `example.html` for working demo.

### Mind the dot!
Do not forget to add a dot (.) in your model object to avoid [issues with scope inheritance](https://github.com/angular/angular.js/wiki/Understanding-Scopes). E.g. use `$scope.datePicker.date` instead of `$scope.date`.

## Advanced usage

####**Extra Options**  
These are options beyond those provided in daterangepicker.

`pickerClasses` : **string**  
-- additional classesadded to picker dropdown element

`cancelOnOutsideClick` : **boolean**  (default: true)  <sup><sub>(only applicable when autoApply==false)</sub></sup>  
If true, then clicking outside of the picker, after value has been changed on calendar,
will trigger clicking cancel rather than applying value to model.
If false, apply will be triggered.

`changeCallback` : **function(startDate, endDate, label)**  
This will be called in the second $.daterangepicker callback parameter


####**Optional Attributes**

`picker` : **object**  
-- object to assign dateRangePicker data object to

`options` : **object** (watched)  
-- all dateRangePicker options

`clearable` : **boolean**  (watched)  
-- will change cancel button to clear and use `options.locale.clearLabel` for text

`min` & `max` : **moment** || *date string* (watched)  
-- sets min/max date values for picker

`picker-classes` : **string**  
-- additional classes added to picker dropdown element

## Example element
```
<input date-range-picker class="form-control date-picker" type="text"
       ng-model="datePicker.date"
       picker="datePicker.picker"
       picker-classes="extra-class-names"
       min="'2014-02-23'"
       max="datePicker.maxDate"
       options="datePicker.options"
       options="{locale: {separator: ":"}}"
       />
```


## Example options

```
$scope.dateRangePicker = {
    date: {startDate: moment().subtract(1, 'years'), endDate: moment().add(1, 'years')} 
    picker: null,
    options: {
        pickerClasses: 'custom-display', //angular-daterangepicker extra
        buttonClasses: 'btn',
        applyButtonClasses: 'btn-primary',
        cancelButtonClasses: 'btn-danger',
        locale: {
            applyLabel: "Apply",
            cancelLabel: 'Cancel',
            customRangeLabel: 'Custom range',
            separator: ' - ',
            format: "YYYY-MM-DD", //will give you 2017-01-06
            //format: "D-MMM-YY", //will give you 6-Jan-17
            //format: "D-MMMM-YY", //will give you 6-January-17
        },
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()]
        },
        eventHandlers: {
            'apply.daterangepicker': function(event, picker) { console.log('applied'); }
        }
    }
};
```

## Events

Optionally, event handlers can be passed in through the `eventHandlers` attribute of `options`.

```
<input date-range-picker class="form-control date-picker" type="text" ng-model="date"
options="{eventHandlers: {'show.daterangepicker': function(ev, picker) { ... }}}"/>
```

All event handlers from the Bootstrap daterangepicker are supported. For reference, the complete list is below:

`show.daterangepicker`: Triggered when the picker is shown

`hide.daterangepicker`: Triggered when the picker is hidden

`showCalendar.daterangepicker`: Triggered when the calendar is shown

`hideCalendar.daterangepicker`: Triggered when the calendar is hidden

`apply.daterangepicker`: Triggered when the apply button is clicked

`cancel.daterangepicker`: Triggered when the cancel button is clicked

## Compatibility
Version > 0.3.0 requires [Bootstrap Datepicker](https://github.com/dangrossman/bootstrap-daterangepicker) 3.0.3 and newer.
Version > 0.2.0 requires [Bootstrap Datepicker](https://github.com/dangrossman/bootstrap-daterangepicker) 2.0.0 and newer.
Version > 0.1.1 requires [Bootstrap Datepicker](https://github.com/dangrossman/bootstrap-daterangepicker) 1.3.3 and newer.

## Changes of note
####0.3.0
`cancelOnOutsideClick` - enabled by default, was previously unhandled


## Links
See [original documentation](https://github.com/dangrossman/bootstrap-daterangepicker).

## Issues and Pull Requests
The PRs are more than welcome ??? thank you for those.

Please send me PRs only for `*.coffee` code. **Please, do not include Javascript and minified Javascript into PRs.**
Javascript and minified Javascript will be generated later with `grunt dist` command
just before the release.

[![Throughput Graph](https://graphs.waffle.io/fragaria/angular-daterangepicker/throughput.svg)](https://waffle.io/fragaria/angular-daterangepicker/metrics)

## Contributors
See [CONTRIBUTORS.md](https://github.com/fragaria/angular-daterangepicker/blob/master/CONTRIBUTORS.md) for all the great folks who contributed to this repo!
Thank you, guys!
