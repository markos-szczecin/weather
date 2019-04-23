import {GoogleApiWrapper} from "google-maps-react";
import {withGoogleMap, GoogleMap} from 'react-google-maps';
import React from "react";
import $ from 'jquery';
import * as ReactDOM from "react-dom";
import { Button, Modal } from 'react-bootstrap';
import MyLoader from './Loader';

const LoadingContainer = <div id="map">Ładowanie mapy...</div>;

export const getCurrentLocation = () => {
    return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(position => resolve(position), e => reject(e));
    });
};

class WeatherInfo extends React.Component
{
    constructor(props) {
        super(props);

        this.handleShow = this.handleShow.bind(this);
        this.handleClose = this.handleClose.bind(this);

        this.state = {
            show: false,
        };
    }

    static show() {
        $('#btn-show').trigger('click');
    }

    handleClose() {
        this.setState({ show: false });
    }

    handleShow() {
        this.setState({ show: true });
    }

    render() {
        return (
            <>
                <Button id="btn-show" className="d-none" variant="primary" onClick={this.handleShow}>
                    Launch demo modal
                </Button>
                <Modal
                    show={this.state.show} onHide={this.handleClose}
                    {...this.props}
                    size="md"
                    aria-labelledby="contained-modal-title-vcenter"
                    centered
                >
                    <Modal.Header closeButton>
                        <Modal.Title>{this.props.locationName}</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div><strong>Szerokość geograficzna:</strong> {this.props.lat}</div>
                        <div><strong>Długość geograficzna:</strong> {this.props.lng}</div>
                        <div><strong>Temperatura:</strong> {this.props.temperature}</div>
                        <div><strong>Wiatr (prędkość | kierunek):</strong> {this.props.wind}</div>
                        <div><strong>Zachmurzenie:</strong> {this.props.cloud}</div>
                        <div><strong>Opis:</strong> {this.props.description}</div>
                    </Modal.Body>
                    <Modal.Footer>
                    </Modal.Footer>
                </Modal>
            </>
        );
    }
}

class WeatherInfoError extends WeatherInfo
{
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <>
                <Button id="btn-show" className="d-none" variant="primary" onClick={this.handleShow}>
                    Launch demo modal
                </Button>
                <Modal
                    show={this.state.show} onHide={this.handleClose}
                    {...this.props}
                    size="lg"
                    aria-labelledby="contained-modal-title-vcenter"
                    centered
                >
                    <Modal.Header closeButton>
                        <Modal.Title>Houston, We have a problem :(</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div>Sorry, We are unable to download weather data for pointed location. Please try again later.</div>
                    </Modal.Body>
                    <Modal.Footer>
                    </Modal.Footer>
                </Modal>
            </>
        )
    }
}

export class MyGoogleMap extends React.Component
{
    state = {
        showingInfoWindow: false,
        activeMarker: {},
        selectedPlace: {},
        currentLocation: {
            lat: 53.415477,
            lng: 14.533156
        }
    };
    currentLocation = {};
    componentDidMount() {
        return getCurrentLocation().then(position => {
            if (position) {
                this.setState({
                    showingInfoWindow: false,
                    activeMarker: {},
                    selectedPlace: {},
                    currentLocation: {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    }
                })
            }
        }).catch(reason => {
            console.log(reason)
        });
    }

    static renderWeatherInfo(data) {
        ReactDOM.render(
            <WeatherInfo
                locationName={data.location_name}
                lng={data.lng}
                lat={data.lat}
                temperature={data.temperature}
                wind={data.wind}
                cloud={data.cloud}
                description={data.description}
            />,
            document.getElementById('weather-info'));
        WeatherInfo.show();
    }

    static renderWeatherError() {
        ReactDOM.render(<WeatherInfoError />, document.getElementById('weather-info'));
        WeatherInfoError.show();
    }

    getWeather(lat, lng) {
        MyLoader.showLoader();
        $.ajax({
            url: '/weather',
            data: {
                lat: lat,
                lng: lng,
                unit: $('[name="unit"]').val()
            },
            success: function (e) {
                if (e && typeof e.data !== "undefined") {
                    let data = JSON.parse(e.data);
                    MyGoogleMap.renderWeatherInfo(data);
                } else {
                    MyGoogleMap.renderWeatherError();
                }
                MyLoader.hideLoader();
            }
        })
    }

    handleClickedMap = (e) => {
        let lat = e.latLng.lat();
        let lng = e.latLng.lng();
        this.getWeather(lat, lng)
    };

    render() {
        const GoogleMapExample = withGoogleMap(props => (
            <GoogleMap
                defaultCenter={{
                    lat: parseFloat(this.state.currentLocation.lat),
                    lng: parseFloat(this.state.currentLocation.lng)
                }}
                defaultZoom={7}
                onClick={this.handleClickedMap}
            >
            </GoogleMap>
        ));

        return (
            <div>
                <GoogleMapExample
                    containerElement={ LoadingContainer }
                    mapElement={ <div style={{ height: `100%` }} /> }
                />
                <div id="weather-info"/>
            </div>
        );
    }
}

export default GoogleApiWrapper({
    apiKey: ''
})(MyGoogleMap)


