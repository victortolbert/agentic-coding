export type Board = {
    id: number;
    title: string;
    description: string | null;
    is_public?: boolean;
    pins_count?: number;
    created_at: string;
};

export type Pin = {
    id: number;
    board_id: number;
    image_url: string;
    note: string | null;
};
