import { Component, OnInit } from '@angular/core';
import { EventService } from '../event.service';

@Component({
  selector: 'app-myevents',
  templateUrl: './myevents.component.html',
  styleUrls: ['./myevents.component.css']
})
export class MyeventsComponent implements OnInit {
  events: any[] = [];
  selectedEvent: any = {}; // Ensure selectedEvent has an id_e propert
  searchTerm: string = ''; // Define searchTerm property

  constructor(private eventService: EventService) { }

  ngOnInit(): void {
    this.loadEvents();
  }

  loadEvents() {
    this.eventService.getEvents().subscribe((data: any[]) => {
      this.events = data;
    });
  }
  
  setSelectedEvent(event: any) {
    this.selectedEvent = { ...event }; // Copy the event object to avoid reference issues
  }
  
  onSubmit(): void {
    this.eventService.updateEvent(this.selectedEvent).subscribe((res: any) => {
      if (res.status === 'success') {
        console.log('Event updated successfully.');
        // Refresh events after update
        this.loadEvents();
        // this.loadEvents(); // Uncomment this if you have a method to refresh events
      } else {
        console.error('Error updating event:', res.message);
      }
    });
  }
 
  

  onDelete(eventName: string) {
    if (!eventName) {
        console.error('Error deleting event: Event name not provided.');
        return;
    }

    if (confirm("Are you sure you want to delete this event?")) {
        this.eventService.deleteEvent(eventName).subscribe((res: any) => {
            if (res.status === 'success') {
                console.log('Event deleted successfully.');
                // Refresh events after delete
                this.loadEvents();
            } else {
                console.error('Error deleting event:', res.message);
            }
        });
    }
  }
    ///onSearch(): void {
    ///this.eventService.searchEvents(this.searchTerm).subscribe((events: any[]) => {
      ///.events = events || [];
      ///console.log('Events fetched successfully:', this.events);
    ///}, (error: any) => {
      ///console.error('Error searching events:', error);
    //});
  //}


}