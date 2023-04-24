import {useState} from "react";
import {useUserContext} from "@/components/Context/UserContext";

const useCreateUserModel = () => {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => setIsModalOpen(true);
    const handleCloseModal = () => setIsModalOpen(false);

    return {
        handleOpenModal,
        handleCloseModal,
        isModalOpen,
        setIsModalOpen
    }
};

const useCreateUser = ({handleClose}) => {
    const { createUser } = useUserContext();

    const [email, setEmail] = useState('');
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');

    const handleSubmit = () => {
        createUser({email,firstName,lastName});
        handleClose();
    };
    return {handleSubmit, email, setEmail, firstName, setFirstName,lastName, setLastName}
};

export {useCreateUserModel,useCreateUser};