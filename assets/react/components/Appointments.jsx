import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ReactDOMClient from "react-dom/client";

function Appointments() {
    const [appointments, setAppointments] = useState([]);

    useEffect(() => {
        axios.get('/api/myAppointments')
            .then(response => {
                setAppointments(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    const cancelAppointment = (id) => {
        axios.post(`/api/cancelAppointment/${id}`)
            .then(response => {
                console.log(response.data);
                axios.get('/api/myAppointments')
                    .then(response => {
                        setAppointments(response.data);
                    })
                    .catch(error => {
                        console.error('There was an error!', error);
                    });
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }

    if (!appointments) {
        return <div>Loading...</div>;
    }

    return (
        <>
            <p className="upcoming-appointments">Nadchodzące wizyty:</p>
            {appointments.map((appointment, index) => (
                <div className="appointment" key={index}>
                    <br />
                    <p>lek. dent. {appointment.doctor.name} {appointment.doctor.surname}</p>
                    <p>Data wizyty: {new Date(appointment.date).toLocaleString([], { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                    <a onClick={() => cancelAppointment(appointment.id)}>Odwołaj</a>
                </div>
            ))}
        </>
    );
}

export default Appointments;

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementsByClassName('appointments')[0];
    if (container !== null) {
        const root = ReactDOMClient.createRoot(container);
        root.render(<Appointments/>);
    }
});