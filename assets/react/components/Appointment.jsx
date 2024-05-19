import React, { useEffect, useState } from 'react';

function Appointment({ date, doctor, onReserve }) {
    return (
        <div className="appointment">
            <p>{date}</p>
            <p>{doctor.name} {doctor.surname}</p>
            <a onClick={onReserve}>Rezerwuj</a>
        </div>
    );
}

export default Appointment;