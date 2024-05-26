import React, { useState, useEffect } from 'react';
import axios from 'axios';
import ReactDOMClient from "react-dom/client";
import Appointment from "./Appointment";

function ReserveForm() {
    const [appointments, setAppointments] = useState([]);
    const [doctors, setDoctors] = useState([]);
    const [doctor, setDoctor] = useState('all');
    const [dateFrom, setDateFrom] = useState('');
    const [dateTo, setDateTo] = useState('');
    const [firstLoad, setFirstLoad] = useState(true);

    useEffect(() => {
        axios.get('/api/doctors-details')
            .then(response => {
                console.log(response.data);
                setDoctors(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    const handleSubmit = (event) => {
        event.preventDefault();
        setFirstLoad(false);
        let url = `/api/searchAppointments/${dateFrom}/${dateTo}`;
        if (doctor !== 'all') {
            url += `/${doctor}`;
        }
        axios.get(url)
            .then(response => {
                console.log(response.data);
                setAppointments(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    };
    const reserveAppointment = (id) => {
        axios.post(`/api/reserveAppointment/${id}`)
            .then(response => {
                console.log(response.data);
                setAppointments(appointments.filter(appointment => appointment.id !== id));
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    };
    return (
        <div className="login-main">
            <div className="login-panel">
                <form onSubmit={handleSubmit}>
                    <label htmlFor="doctor">Lekarz:</label>
                    <select id="doctor" name="doctor" required value={doctor} onChange={e => setDoctor(e.target.value)}>
                        <option value="all">Wszyscy</option>
                        {doctors.map((doctor, index) => (
                            <option key={index} value={doctor.id}>lek. dent. {doctor.user.name} {doctor.user.surname}</option>
                        ))}
                    </select>
                    <hr />

                    <label htmlFor="date_from">Data od:</label>
                    <input type="date" id="date_from" name="date_from" required min={new Date().toISOString().split('T')[0]} value={dateFrom} onChange={e => setDateFrom(e.target.value)} />
                    <hr />

                    <label htmlFor="date_to">Data do:</label>
                    <input type="date" id="date_to" name="date_to" required min={new Date().toISOString().split('T')[0]} value={dateTo} onChange={e => setDateTo(e.target.value)} />
                    <hr />

                    <button type="submit" className="login-button">Wyszukaj</button>
                </form>


            </div>
            {firstLoad ? null : appointments.length === 0 ? (
                <p>Brak wizyt</p>
            ) : (
                appointments.map((appointment, index) => (
                    <Appointment className={"appointment"} key={index} date={appointment.date} doctor={appointment.doctor} onReserve={() => reserveAppointment(appointment.id)} />
                ))
            )}
        </div>
    );
}

export default ReserveForm;

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementsByClassName('container')[0];
    if (container !== null) {
        const root = ReactDOMClient.createRoot(container);
        root.render(<ReserveForm/>);
    }
});