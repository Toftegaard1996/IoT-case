import {format, parseISO} from "date-fns";
export function formattimedate(date) {
    return format(parseISO(date), 'HH:mm:ss - dd MMM - yyyy')
}

export function formatdate(date) {
    return format(parseISO(date), 'dd MMM - yyyy')
}
