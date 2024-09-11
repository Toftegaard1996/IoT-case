//Here the different types are defined, depending on what is put into the database, and extracted again

export interface OfficeRooms {
    id: number;
    roomName: string
    temp: string
    humidity: string;
    noise: string;
    light: string;
    brightness: bigint;
    mode: string;
}

export interface Settings {
    id: number;
    roomName: string;
    interval: string;
    celcius: boolean;
    maxTemp: string;
    minTemp: string;
    startHour: string;
    endHour: string;
    motion: boolean;
}
