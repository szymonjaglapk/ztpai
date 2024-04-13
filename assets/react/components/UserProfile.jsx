import React from 'react';
import ReactDOMClient from 'react-dom/client';

const UserProfilePanelLine = ({ title, value, className }) => (
    <div className={className}>
        {title}: {value}
    </div>
);

const UserProfile = () => {
    return (
        <React.Fragment>
            <UserProfilePanelLine title="Imię" value="Uzytkownik" className="line nameText" />
            <br/><hr/><br/>
            <UserProfilePanelLine title="Nazwisko" value="Dobry" className="line surnameText" />
            <br/><hr/><br/>
            <UserProfilePanelLine title="Email" value="uzytkownik@pk.edu.pl" className="line emailText" />
            <br/><hr/><br/>
            <UserProfilePanelLine title="Nr telefonu" value="567 345 234" className="line phoneText" />
            <br/><hr/><br/>
            <button className="change editProfileButton">Zmień</button>
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