import React from 'react';
import UserListSection from '../components/Users/UserListSection';
import {Container} from "@mui/material";
import {UserProvider} from "@/components/Context/UserContext";

function HomePage() {
    return (
        <UserProvider>
            <Container>
                <UserListSection/>
            </Container>
        </UserProvider>
    );
}

export default HomePage;
