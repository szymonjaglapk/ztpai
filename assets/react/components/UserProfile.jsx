import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ReactDOMClient from 'react-dom/client';

const UserProfilePanelLine = ({ title, value, className, isEditing, onValueChange }) => (
    <div className={className}>
        {title}: {isEditing ? <input type="text" value={value} onChange={onValueChange} /> : value}
    </div>
);

const UserProfile = () => {
    const [user, setUser] = useState(null);
    const [isEditing, setIsEditing] = useState(false);

    useEffect(() => {
        axios.get('/api/myId')
            .then(response => {
                return response.data;
            })
            .then(data => {
                setUser(data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    const handleEditClick = () => {
        setIsEditing(true);
    };

    const handleInputChange = (event, field) => {
        setUser({...user, [field]: event.target.value});
    };

    const handleSaveClick = () => {
        axios.patch(`/api/user_detailss/${user.id}`, user, {
            headers: {
                'Content-Type': 'application/merge-patch+json'
            }
        })
            .then(response => {
                setIsEditing(false);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });

        axios.patch(`/api/users/${user.id}`, user, {
            headers: {
                'Content-Type': 'application/merge-patch+json'
            }
        })
            .then(response => {
                setIsEditing(false);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    };


    if (!user) {
        return <div>Loading...</div>;
    }

    return (
        <React.Fragment>
            <UserProfilePanelLine title="Imię" value={user.name} className="line nameText" isEditing={isEditing} onValueChange={(event) => handleInputChange(event, 'name')} />
            <br/><hr/><br/>
            <UserProfilePanelLine title="Nazwisko" value={user.surname} className="line surnameText" isEditing={isEditing} onValueChange={(event) => handleInputChange(event, 'surname')} />
            <br/><hr/><br/>
            <UserProfilePanelLine title="Email" value={user.email} className="line emailText" isEditing={isEditing} onValueChange={(event) => handleInputChange(event, 'email')} />
            <br/><hr/><br/>
            <UserProfilePanelLine title="Nr telefonu" value={user.phone} className="line phoneText" isEditing={isEditing} onValueChange={(event) => handleInputChange(event, 'phone')} />
            <br/><hr/><br/>
            {isEditing ? <button className="change saveProfileButton" onClick={handleSaveClick}>Zapisz</button> : <button className="change editProfileButton" onClick={handleEditClick}>Zmień</button>}
        </React.Fragment>
    );
};

export default UserProfile;

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementsByClassName('profile-panel')[0];
    if (container !== null) {
        const root = ReactDOMClient.createRoot(container);
        root.render(<UserProfile />);
    }
});