import Swal from "sweetalert2";
import { serialize } from "object-to-formdata";

export const swalNotification = (type, message) => {
    switch (type) {
        case "success":
            return Swal.fire({
                icon: type,
                title: "Success!",
                text: message,
                showConfirmButton: false,
                timer: 2000
            });
        case "success-confirm":
            return Swal.fire({
                icon: "success",
                title: "Success!",
                text: message,
                showConfirmButton: true,
                confirmButtonText: "Close"
            });
        case "error":
            return Swal.fire({
                icon: type,
                title: "Error!",
                text: message,
                showConfirmButton: true,
                confirmButtonText: "Close",
                confirmButtonColor: "#138496"
            });
    }
};

export const truncateText = (text, limit) => {
    return text.length > limit ? text.substring(0, limit) + "..." : text;
};

export const serializeForm = data => {
    return serialize(data);
};

export const confirmAction = (overrides = {}) => {
    return new Promise((resolve, reject) => {
        const options = {
            icon: "warning",
            title: "Delete item!",
            text: "Are you sure you want to proceed?",
            showCancelButton: true,
            cancelButtonColor: "#3085d6",
            confirmButtonColor: "#c82333",
            cancelButtonText: "Cancel",
            confirmButtonText: "Delete",
            ...overrides,
        };
        Swal.fire(options).then((result) => {
            if (result.isConfirmed) {
                resolve();
            }
        });
    });
};

