import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ReactDOMClient from "react-dom/client";

function AdminUsers() {
    const [users, setUsers] = useState([]);

    useEffect(() => {
        axios.get('/api/admin_users')
            .then(response => {
                setUsers(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    const deleteUser = (id) => {
        axios.post(`/api/deleteUser/${id}`)
            .then(response => {
                console.log(response.data);
                axios.get('/api/admin_users')
                    .then(response => {
                        setUsers(response.data);
                    })
                    .catch(error => {
                        console.error('There was an error!', error);
                    });
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }
    if (!users) {
        return <div>Loading...</div>;
    }

    return (
        <>
            {users.map((user, index) => (
                <div className="user" key={index}>
                    <p>{user.name} {user.surname}</p>
                    <a onClick={() => deleteUser(user.id)}>Usuń</a>
                </div>
            ))}
        </>
    );
}

export default AdminUsers;

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementsByClassName('users')[0];
    if (container !== null) {
        const root = ReactDOMClient.createRoot(container);
        root.render(<AdminUsers/>);
    }
});