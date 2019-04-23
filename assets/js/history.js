require('../css/app.css');
import React from "react";
import History from "./components/History";
import * as ReactDOM from "react-dom";
import MyLoader from "./components/Loader";
import $ from 'jquery';

ReactDOM.render(<MyLoader />, document.getElementById('loader'));
ReactDOM.render(<History page={1} />, document.getElementById('main'));

$('#unit-select').change(function () {
    MyLoader.showLoader();
    location.pathname = '/history/' + $(this).val();
});