import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ReactDOMClient from "react-dom/client";

function PastAppointments() {
    const [appointments, setAppointments] = useState([]);

    useEffect(() => {
        axios.get('/api/myPastAppointments')
            .then(response => {
                setAppointments(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    if (!appointments) {
        return <div>Loading...</div>;
    }

    return (
        <>
            <p className="historical-appointments">Odbyte wizyty:</p>
            {appointments.map((appointment, index) => (
                <div className="appointment" key={index}>
                    <p>lek. dent. {appointment.doctor.name} {appointment.doctor.surname}</p>
                    <p>Data wizyty: {new Date(appointment.date).toLocaleString([], { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                </div>
            ))}
        </>
    );
}

export default PastAppointments;

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementsByClassName('appointments')[0];
    if (container !== null) {
        const root = ReactDOMClient.createRoot(container);
        root.render(<PastAppointments/>);
    }
});