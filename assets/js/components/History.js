import React from "react";
import ReactTable from "react-table";
import "react-table/react-table.css";
import MyLoader from "./Loader";
import $ from "jquery";

export class Statistics extends React.Component {
    render() {
        return (
            <div className={"container"}>
                <div className={"row"}>
                    <div className={"col-6 stat-key"}>
                        Temperatura maksymalna:
                    </div>
                    <div className={"col-6"}>
                        {symfonyData.statistics.max_temp}
                    </div>
                </div>
                <div className={"row"}>
                    <div className={"col-6 stat-key"}>
                        Temperatura minimalna:
                    </div>
                    <div className={"col-6"}>
                        {symfonyData.statistics.min_temp}
                    </div>
                </div>
                <div className={"row"}>
                    <div className={"col-6 stat-key"}>
                        Temperatura średnia:
                    </div>
                    <div className={"col-6"}>
                        {symfonyData.statistics.average_temp}
                    </div>
                </div>
                <div className={"row"}>
                    <div className={"col-6 stat-key"}>
                        Najczęściej sprawdzane miejsca:
                    </div>
                    <div className={"col-6"}>
                        {symfonyData.statistics.common_places.join(', ')}
                    </div>
                </div>
            </div>
        )
    }
}

class History extends React.Component {
    constructor() {
        super();
        this.state = {
            data: [],
            loading: false,
            pages: 10,
            page: 1
        };
    }

    getTestData(page, handler) {
        page++;
        fetch('/history-page/' + page + '/' + $('[name="unit"]').val())
            .then(response => response.json())
            .then(data => handler(data));
    }

    render() {
        const { data } = this.state;
        return (
            <div id={"history-data"}>
                <div id={"statistics"}>
                    <Statistics />
                </div>

            <ReactTable
                data={data}
                pages={this.state.pages}
                columns={[
                    {
                        Header: "ID",
                        accessor: "id"
                    }, {
                        Header: "Szerokość geo.",
                        accessor: "lat"
                    }, {
                        Header: "Długość geo",
                        accessor: "lng"
                    }, {
                        Header: "Zachmurzenie",
                        accessor: "cloud"
                    }, {
                        Header: "Temperatura",
                        accessor: "temperature"
                    }, {
                        Header: "Wiatr (prędkość | kierunek)",
                        accessor: "wind"
                    }, {
                        Header: "Opis",
                        accessor: "description"
                    }, {
                        Header: "Czas sprawdzenia",
                        accessor: "date_time"
                    }
                ]}
                previousText={'Cofnij'}
                nextText={'Dajej'}
                loadingText={''}
                noDataText={''}
                pageText={'Strona'}
                ofText={'z'}
                rowsText={'wyników'}
                defaultPageSize={30}
                className="-striped -highlight"
                loading={false}
                showPagination={true}
                showPaginationTop={false}
                showPaginationBottom={true}
                showPageSizeOptions={false}
                onPageChange={MyLoader.showLoader}
                manual // this would indicate that server side pagination has been enabled
                onFetchData={(state, instance) => {
                    // MyLoader.showLoader();
                    this.setState({loading: true});
                    this.getTestData(state.page, (res) => {
                        this.setState({
                            data: res.weathers,
                            pages: symfonyData.weathersLength,
                            loading: false
                        });
                        MyLoader.hideLoader();
                    });
                }}
            />
            </div>
        );
    }
}
export default History