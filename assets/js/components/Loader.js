import Loader from 'react-loaders'
import React from "react";
import 'loaders.css';
import $ from 'jquery';

class MyLoader extends React.Component {
    render() {
        return(
            <Loader type="pacman" />
        )
    }
    static showLoader() {
        $('#loader').removeClass('d-none');
    }

    static hideLoader() {
        $('#loader').addClass('d-none');
    }
}

export default MyLoader;