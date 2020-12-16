@extends('layouts.admin')

@section('title', 'Panel de Administración')

@section('content')
        <div class="row">
            <div class="col-12">
                <table class="table table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Date of Birth</th>
                            <th>Active?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Risa D. Pearson</td>
                            <td>336-508-2157</td>
                            <td>July 24, 1950</td>
                            <td>
                                <!-- Switch-->
                                <div>
                                    <input type="checkbox" id="switch1" checked data-switch="success"/>
                                    <label for="switch1" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Ann C. Thompson</td>
                            <td>646-473-2057</td>
                            <td>January 25, 1959</td>
                            <td>
                                <!-- Switch-->
                                <div>
                                    <input type="checkbox" id="switch2" checked data-switch="success"/>
                                    <label for="switch2" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Paul J. Friend</td>
                            <td>281-308-0793</td>
                            <td>September 1, 1939</td>
                            <td>
                                <!-- Switch-->
                                <div>
                                    <input type="checkbox" id="switch3" data-switch="success"/>
                                    <label for="switch3" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Linda G. Smith</td>
                            <td>606-253-1207</td>
                            <td>May 3, 1962</td>
                            <td>
                                <!-- Switch-->
                                <div>
                                    <input type="checkbox" id="switch4" data-switch="success"/>
                                    <label for="switch4" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
@endsection